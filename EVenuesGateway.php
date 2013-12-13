<?php

class EVenuesGateway extends TheTwelve\Foursquare\VenuesGateway
{
    const CACHE_VENUE_PREFIX = 'vanue';
    const CACHE_SEARCH_PREFIX = 'search';
    
    public function getVenue($venueId, $expire = null, $dependency = null)
    {
        $key = $this->getCacheKey(self::CACHE_VENUE_PREFIX, array('venue_id' => $venueId));
        $venue = Yii::app()->cache->get($key);
        
        if($venue === false) {
            $venue = parent::getVenue($venueId);
            
            if($expire !== null) {
                Yii::app()->cache->set($key, $venue, $expire, $dependency);
            }
        }
        
        return $venue;
    }
    
//    public function explore(array $params = array(), $expire = null, $dependency = null)
//    {
//        $key = $this->getCacheKey('explore', $params);
//        $response = Yii::app()->cache->get($key);
//        
//        if($response === false) {
//            $resource = '/venues/explore';
//            $response = $this->makeApiRequest($resource, $params);
//
//            if($expire !== null) {
//                Yii::app()->cache->set($key, $response, $expire, $dependency);
//            }
//        }
//        
//        return $response;
//    }
    
    public function search(array $params = array(), $expire = null, $dependency = null)
    {
        $key = $this->getCacheKey(self::CACHE_SEARCH_PREFIX, $params);
        $venues = Yii::app()->cache->get($key);
        
        if($venues === false) {
            $venues = parent::search($params);
            
            if($expire !== null) {
                Yii::app()->cache->set($key, $venues, $expire, $dependency);
            }
        }
        
        return $venues;
    }
    
//    public function photos($venueId, array $params = array(), $expire = null, $dependency = null)
//    {
//        $key = $this->getCacheKey('photos'.$venueId, $params);
//        $photos = Yii::app()->cache->get($key);
//        
//        if($photos === false) {
//            $resource = '/venues/' . $venueId . '/photos';
//            $response = $this->makeApiRequest($resource, $params);
//
//            $photos = $response->photos;
//            
//            if($expire !== null) {
//                Yii::app()->cache->set($key, $photos, $expire, $dependency);
//            }
//        }
//        
//        return $photos;
//    }
//    
//    public function tips($venueId, array $params = array(), $expire = null, $dependency = null)
//    {
//        $key = $this->getCacheKey('tips'.$venueId, $params);
//        $tips = Yii::app()->cache->get($key);
//        
//        if($tips === false) {
//            $resource = '/venues/' . $venueId . '/tips';
//            $response = $this->makeApiRequest($resource, $params);
//
//            $tips = $response->tips;
//            
//            if($expire !== null) {
//                Yii::app()->cache->set($key, $tips, $expire, $dependency);
//            }
//        }
//        
//        return $tips;
//    }
//    
//    public function trending(array $params = array(), $expire = null, $dependency = null)
//    {
//        $key = $this->getCacheKey('trending', $params);
//        $venues = Yii::app()->cache->get($key);
//        
//        if($venues === false) {
//            $resource = '/venues/trending';
//            $response = $this->makeApiRequest($resource, $params);
//
//            $venues = $response->venues;
//            
//            if($expire !== null) {
//                Yii::app()->cache->set($key, $venues, $expire, $dependency);
//            }
//        }
//        
//        return $venues;
//    }
    
    protected function getCacheKey($key, array $params = array())
    {
        return get_class($this).md5($key.serialize($params));
    }
}