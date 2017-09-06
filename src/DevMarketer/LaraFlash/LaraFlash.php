<?php

namespace DevMarketer\LaraFlash;

use Illuminate\Session\Store;

class LaraFlash
{
	/**
   * The session store.
   *
   * @var Illuminate\Session\Store
   */
  protected $session;

	/**
   * The notifications store.
   *
   * @var Illuminate\Support\Collection
   */
  public $notifications;

	/**
	 * Construct a new LaraFlash instance,
	 * and initialize $notifications as a collection
	 *
	 * @param Illuminate\Session\Store $session
	 */
	function __construct(Store $session)
	{
		$this->session = $session;
		$this->notifications = collect();
	}

	/**
   * Add a notification to our collection.
   *
   * @param  string|NULL   	$content
   * @param  array    			$options
   * @return $this
   */
    public function add($content = NULL, $options = [])
    {
			if (!empty($content)) $options['content'] = $content;
      $this->notifications->push(new Notification($options));
      return $this->flash();
    }

	/**
   * Alias for the "add" method.
   *
   * @param  string   $content
   * @param  array    $options
   * @return $this
   */
    public function push($content = NULL, $options = [])
    {
      return $this->add($content, $options);
    }

	/**
   * Alias for the "add" method:
	 *  Designed for use with the fluent chainable commands,
	 *  but will work just like the "push()" and "add()" methods
   *
   * @param  string   $content
   * @param  array    $options
   * @return $this
   */
    public function new($content = NULL, $options = [])
    {
      return $this->add($content, $options);
    }

	/**
	 * Set priority property for chaining notification
	 *
	 * @param 	$params
	 * @return $this
	 */
		public function typeShorthand($type, $params = [])
		{
			$options = [];
			$content = NULL;
			$count = count($params);

			if ($count < 1) {
				# no params passed, set last notification type
				$this->updateLastNotification(['type' => $type]);
			} elseif ($count == 1) {
				if (is_array($params[0])) {
					# assume its an options array
					$options = $params[0];
				} else {
					# assume the one param is content
					$content = $params[0];
				}
			} elseif ($count == 2) {
				if (is_array($params[1])) {
					# assume second param is options array, first param is content
					$content = $params[0];
					$options = $params[1];
				} else {
					$content = $params[0];
					$options = ['title' => $params[1]];
				}
			} elseif ($count == 3) {
				if (is_array($params[2])) {
					$content = $params[0];
					$options = array_merge($params[2], ['title' => $params[1]]);
				} else {
					throw new Exception("When 3 parameters given, third parameter must be an Array");
				}
			}

			return $this->add($content, array_merge($options, ['type' => $type]));
		}

	/**
   * Fluent Interface
	 *
   * Create a new notification fluently with chainable methods
	 * ===========================================
   */

	/**
   * Set type property for chaining notification
   *
	 * @param string
   * @return $this
   */
    public function type($type)
    {
			return $this->updateLastNotification(['type' => $type]);
    }

	/**
   * Set content property for chaining notification
   *
	 * @param string
   * @return $this
   */
    public function content($content)
    {
			return $this->updateLastNotification(['content' => $content]);
    }

	/**
   * Set title property for chaining notification
   *
	 * @param string
   * @return $this
   */
    public function title($title)
    {
			return $this->updateLastNotification(['title' => $title]);
    }

	/**
   * Set priority property for chaining notification
   *
	 * @param int
   * @return $this
   */
    public function priority($priority)
    {
			return $this->updateLastNotification(['priority' => $priority]);
    }

	/**
	 * Set type property to info with variable length parameters
	 *   0 params = () set last notification to "info" type for  fluent chaining
	 *   1 param = (Array $options)
	 *   2 params = ($content, Array $options)
 	 *   3 params = ($content, $title, Array $options)
	 *
	 * @param 	variable	$params
	 * @return $this
	 */
		public function info(...$params)
		{
			return $this->typeShorthand('info', $params);
		}

	/**
	 * Set type property to SUCCESS with variable length parameters
	 *   0 params = () set last notification to "success" type for  fluent chaining
	 *   1 param = (Array $options)
	 *   2 params = ($content, Array $options)
	 *   3 params = ($content, $title, Array $options)
	 *
	 * @param 	variable	$params
	 * @return $this
	 */
		public function success(...$params)
		{
			return $this->typeShorthand('success', $params);
		}

	/**
	 * Set type property to warning with variable length parameters
	 *   0 params = () set last notification to "warning" type for  fluent chaining
	 *   1 param = (Array $options)
	 *   2 params = ($content, Array $options)
	 *   3 params = ($content, $title, Array $options)
	 *
	 * @param 	variable	$params
	 * @return $this
	 */
		public function warning(...$params)
		{
			return $this->typeShorthand('warning', $params);
		}

	/**
	 * Set type property to danger with variable length parameters
	 *   0 params = () set last notification to "danger" type for  fluent chaining
	 *   1 param = (Array $options)
	 *   2 params = ($content, Array $options)
 	 *   3 params = ($content, $title, Array $options)
	 *
	 * @param 	variable	$params
	 * @return $this
	 */
		public function danger(...$params)
		{
			return $this->typeShorthand('danger', $params);
		}

	/**
   * Retrieval Methods
   *  Used to get notifications
   */

	/**
   * Retrieve all of the LaraFlash notifications as an object
   *
   * @return object $this
   */
    public function notifications()
    {
				return $this->session->get('laraflash');
    }

	/**
   * Alias for the "notifications" method
   *
   * @return object $this
   */
    public function dump()
    {
				return $this->notifications();
    }

	/**
	 * Shortcut for notifications()->all() to return
	 *  an array
	 *
	 * @return array
	 */
		public function all()
		{
				return $this->notifications()->all();
		}

	/**
	 * Get the FIRST notification in the notifications property
	 *
	 * @return /DevMarketer/LaraFlash/Notification
	 */
		protected function first()
		{
			return $this->notifications->first();
		}

	/**
	 * Get the LAST notification in the notifications property
	 *
	 * @return /DevMarketer/LaraFlash/Notification
	 */
		protected function last()
		{
			return $this->notifications->last();
		}

	/**
	 * Keep the LaraFlash session for another request
	 *
	 * @param 	array 	$keys
	 * @return 	$this
	 */
		protected function keep($keys = ["laraflash"])
		{
			// optionally users can pass in an array of other session
			// keys they want to keep in addition to LaraFlash
			return $this->session->keep(array_unique(array_merge($keys, ["laraflash"]), SORT_STRING));
		}

	/**
	 * Clear all of the notifications in the LaraFlash object
	 *
	 * @return $this
	 */
		protected function clear()
		{
				$this->notifications = collect();
				$this->session->forget('laraflash');
				return $this;
		}

	/**
	 * Override a notification with a new one, instantiates new
	 *  notification and sets it equal to options
	 *
	 * @param 	int 		$key
	 * @param		array 	$options
	 * @return 	$this
	 */
		public function override($key = -1, $options = [])
		{
			if ($key >= 0) {
				$notification = $this->notifications->get($key);
			} else {
				$notification = $this->notifications->last();
			}
			$notification->setOptions($options, false);
			return $this->flash();
		}

	/**
	 * Override the latest notification with a new one
	 *
	 * @return $this
	 */
		protected function overrideLast($options = [])
		{
				$this->override(-1, $options);
				return $this;
		}

	/**
   * Update last notification (used for chaining)
   *
	 * @param array
   * @return $this
   */
    public function updateLastNotification($options = [])
    {
			$this->notifications->last()->setOptions($options, true);
			return $this->flash();
    }

	/**
	 * Flash everything to the session.
	 *
	 * @return $this
	 */
		protected function flash()
		{
				$this->session->flash('laraflash', $this->notifications);
				return $this;
		}
}
