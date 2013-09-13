<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class SearchForm extends CFormModel
{
	public $searchquery;
	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('searchquery', 'required'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'searchquery'=>'Search string of service',
		);
	}	
}