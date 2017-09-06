<?php

namespace DevMarketer\LaraFlash;

class Notification
{
	/**
		* The title of the Notification.
		*
		* @var string
		*/
		public $title;

	/**
		* The content of the Notification.
		*
		* @var string
		*/
		public $content;

	/**
		* The priority of the Notification.
		*
		* @var int
		*/
		public $priority;

	/**
		* The type of Notification.
		*
		* @var string
		*/
		public $type;

	/**
   * Construct new Notification instance.
   *
   * @param array $options
   */
	public function __construct($options = [])
	{
		$this->setOptions($options);
	}

	/**
   * Set Notification options to instance.
   *
   * @param  array $options
   * @return $this
   */
  public function setOptions($options = [])
  {
			$defaults = $this->setOptionDefaults();
			$options = array_intersect_key(array_filter($options), $defaults);
			$options = array_merge($options, array_diff_key($defaults, $options));
      foreach ($options as $key => $option) {
          $this->$key = $option;
      }
      return $this;
  }

	/**
   * Set options to defaults from config.
   *
   * @return array
   */
	protected function setOptionDefaults()
	{
		return [
			'title'			=> config('laraflash.defaults.title'),
			'content' 	=> config('laraflash.defaults.content'),
			'type'			=> config('laraflash.defaults.type'),
			'priority' 	=> config('laraflash.defaults.priority'),
		];
	}

}
