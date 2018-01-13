<?php
// Jobs Portal, http://www.netartmedia.net/jobsportal
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php

class Stripe_List extends Stripe_Object
{
  public static function constructFrom($values, $apiKey=null)
  {
    $class = get_class();
    return self::scopedConstructFrom($class, $values, $apiKey);
  }

  public function all($params=null)
  {
    $requestor = new Stripe_ApiRequestor($this->_apiKey);
    list($response, $apiKey) = $requestor->request('get', $this['url'], $params);
    return Stripe_Util::convertToStripeObject($response, $apiKey);
  }
}
