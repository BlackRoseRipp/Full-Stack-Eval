<?php

class Controller {

    private $inputs = array();
    private $keyword = NULL;
    private $message = NULL;


    public function setKeyword($keyword){
        $this->keyword = $keyword;
    }

    public function getKeyword(){
        return $this->keyword;
    }

    private function destroyInputs(){
        $this->inputs = [];
    }

    private function setInputs($input){
        $this->inputs[] = $input;
    }

    public function getInputs(){
        return $this->inputs;
    }

    private function setMessage($message){
        $this->message = $message;
    }

    public function getMessage(){
        return $this->message;
    }



    public function validate($array){
        $valid = false;
        $keyword = strtolower($this->getKeyword());
        foreach($array  AS $arr){
            $this->setInputs($arr);

            if(strtolower($arr) === $keyword){
                $valid = true;
            }

        }

        if(!$valid){
            $this->destroyInputs();
            $this->setMessage("Choices are invalid. User did not type ".$this->getKeyword());
            return false;
        }else{
            $this->setMessage("The following words can be inserted ".implode(",",$this->getInputs()));
            return true;
        }
    }

    public function post() {
        $inputs = $this->getInputs();
        
        if($this->save($inputs)) {
            return [ 'status'=>'success' ];
        } else {
            return ['status'=>'error', 'errorMessage' => $this->getLastErrorMessage()];
        }
    }

    private function save($array){
        if(count($array) > 0){
            $this->setMessage("The following words were inserted ".implode(",",$this->getInputs()));
            return true;
        }else{
            $this->setMessage("Entries could not be inserted");
            return false;

        }

    }
    

}

?>