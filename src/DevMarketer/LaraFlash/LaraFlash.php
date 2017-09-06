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
   * Alias for the "add" method.
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
   * Fluent Interface
   *  Create a new notification fluently
   */

	/**
   * Set type for chaining notification
   *
	 * @param string
   * @return $this
   */
    public function type($type)
    {
			return $this->updateLastNotification(['type' => $type]);
    }

	/**
   * Set content for chaining notification
   *
	 * @param string
   * @return $this
   */
    public function content($content)
    {
			return $this->updateLastNotification(['content' => $content]);
    }

	/**
   * Set title for chaining notification
   *
	 * @param string
   * @return $this
   */
    public function title($title)
    {
			return $this->updateLastNotification(['title' => $title]);
    }

	/**
   * Set priority for chaining notification
   *
	 * @param int
   * @return $this
   */
    public function priority($priority)
    {
			return $this->updateLastNotification(['priority' => $priority]);
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
