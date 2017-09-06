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
   * @param  string   $content
   * @param  array    $options
   * @return $this
   */
    public function add($content, $options = [])
    {
      $options['content'] = $content;
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
    public function push($content, $options = [])
    {
        return $this->add($content, $options);
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
}
