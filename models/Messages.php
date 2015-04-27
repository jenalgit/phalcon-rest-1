<?php

use Phalcon\Mvc\Model;

class Messages extends Model {

    /**
     * @var integer
     */
    protected $id;
    
    /**
     * @var integer
     */
    protected $time;
    
    /**
     * @var integer
     */
    protected $id_sender;
    
    /**
     * @var integer
     */
    protected $id_receiver;

    /**
     * @var string
     */
    protected $content;
    
    /**
     * @var string
     */
    protected $type;

    /**
     * Get all messages from sender to receiver
     * @param type $id_sender
     * @param type $id_receiver
     * @return type
     */
    public function getFlow($id_sender, $id_receiver) {
        $return_messages = array();    
        foreach ($this->find("id_sender = '" . $id_sender . "' AND id_receiver = '" . $id_receiver . "'") as $message) {
            $return_message = array();
            $return_message['id'] = $message->id;
            $return_message['time'] = $message->time;
            $return_message['title'] = $message->content;
            $return_messages[] = $return_message;
        }
        return $return_messages;
    }  
    
    /**
     * Get all messages with this two participants
     * @param type $id_one
     * @param type $id_two
     * @return type
     */
    public function getConversation($id_one, $id_two) {        
        $return_messages = array_merge($this->getFlow($id_one, $id_two), $this->getFlow($id_two, $id_one));
        return $return_messages;
    } 
    
    public function setSingle($id_sender, $id_receiver, $content, $type = 1) {
        $this->id_sender = $id_sender;
        $this->id_receiver = $id_receiver;
        $this->content = $content;
        $this->type = $type;
        
        $this->time = time();    
                
        $this->save();
        
        return $this->id; 
    }
}
