<?php

/**
 * Class Post
 */
class Post extends AppModel {
   /**
	* @var string[][]
	*/
   public $validate = array(
	   'title' => array(
		   'rule' => 'notBlank'
	   ),
	   'body'  => array(
		   'rule' => 'notBlank'
	   )
   );

   /**
	* @param $post
	* @param $user
	*
	* @return bool
	*/
   public function isOwnedBy($post, $user) {
	  return $this->field('id', array('id' => $post, 'user_id' => $user)) !== false;
   }
}