# Full Stack Test

### _Tom RIpp_

## Q1. Given a SQL database with the following table full of data

> CREATE TABLE countries (  
> &nbsp;&nbsp;code CHAR(2) NOT NULL,  
> &nbsp;&nbsp;year INT NOT NULL,  
> &nbsp;&nbsp;gdp_per_capita DECIMAL(10, 2) NOT NULL,  
> &nbsp;&nbsp;govt_debt DECIMAL(10, 2) NOT NULL  
> );

> Please write the SQL statement to show the top 3 average government debts in percent of the
> gdp_per_capita (govt_debt/gdp_per_capita) for those countries of which gdp_per_capita was over
> 40,000 dollars in every year in the last four years.

**_Answer_:**

```
SELECT code, AVG(govt_debt) AS avg_gov_debt, (SELECT SUM(gdp_per_capita) FROM countries WHERE
gdp_per_capita > 40000 AND year >= YEAR(CURDATE()) - 4) AS sum_over_40k,
ROUND((AVG(govt_debt)/(SELECT SUM(gdp_per_capita) FROM countries WHERE gdp_per_capita > 40000 AND
year >= YEAR(CURDATE()) - 4))*100,2) AS percent_over_40k FROM countries WHERE gdp_per_capita > 40000
AND year >= YEAR(CURDATE()) - 4 GROUP BY code ORDER BY AVG(govt_debt) DESC LIMIT 3
```

## Q2. OOP general programming

> Write a program to simulate the following scenario:
>
> - All cars have 1 engine and 1 driver.
> - A car engine can performs operations such as:
>   - Ignite
>   - Accelerate
>   - Burn fuel
>   - Turn belts
>   - Shift gears
> - Some engine behaviors can be invoked directly by the driver, while others cannot.
> - Some engine behaviors trigger other engine behaviors.
> - All cars maintain a record of their own speed and direction.
>
> Use OOP Designs to make needed classes with methods to meet those requirements. You can use any language or
> pseudo-code to write down your results.

**_Answer_:**

```
gears = {
    "1": 5,
    "2": 10,
    "3": 15,
    "4": 20
}

class Car:
    def __init__(self):
        self.driver = 1
        self.engine = 1
        self.speed = 0
        self.direction = ''
        self.gear = 1
        self.fuel_level = 5.0

    def ignite(self):
        if self.fuel_level > 0:
            print('The car has started')
            self.__burn_fuel()
            self.__turn_belts()
        else:
            print("There is no fuel to use.")

    def accelerate(self, duration, direction):
        self.__set_direction(direction)
        for i in range(duration):
            if self.fuel_level > 0:
                self.__burn_fuel()
                self.__set_speed(self.speed + 1)
                if gears[str(self.gear)] < self.speed:
                    self.shift_gears("up")
            else:
                print("There is no more fuel to burn.")


    def __burn_fuel(self):
        self.fuel_level -= 0.1
        print("Fuel is being burned.")

    def __turn_belts(self):
        print("Engine belts are turning")

    def shift_gears(self, direction):
        if direction == "up" and self.gear < 5:
            self.gear += 1
            print("The car is now in gear ", self.gear)
        elif direction == "down" and self.gear > 1:
            self.gear -= 1
            print("The car is now in gear ", self.gear)
        else:
            print("Unable to shift in that direction.")

    def __set_direction(self, direction):
        if direction != self.direction:
            self.direction = direction
            print("The direction of the car is now ", direction)

    def __set_speed(self, speed):
        self.speed = speed
        print('The speed is now ', self.speed)

myCar = Car()
myCar.ignite()
myCar.accelerate(7, "forward")
myCar.shift_gears("up")
myCar.accelerate(5, "forward")
```

## Q3. Web Form Submission and Handling

> In a form, we have three input boxes for users to type in their choices of courses and submit the form without
> refreshing the page(i.e using ajax request). Here are the requirements:
>
> 1. User can type in 1, 2 or 3 courses
> 2. Each choice is case insensitive (also, user can type anything, in any case or leave it empty)
> 3. The choices have to contain “calculus”(in any case, e.g “Calculus” or “CALCULUS”) in one input box.
> 4. Frontend code should make sure the choices contain “calculus”.
> 5. Backend code on the server side needs to have the same validation as in frontend to make sure data is consistent.

```
<form action="/post" /* form submission handler ... */ >
    Choice A: <input type="text" name="choices[]"/>
    Choice B: <input type="text" name="choices[]"/>
    Choice C: <input type="text" name="choices[]"/>
    <input type="submit" value="Submit"/>
</form>
```

> 1. Please use vanilla Javascript or any frontend framework to submit the request.
> 2. Please use any backend framework to handle the request and save the correct data into a database.

**_Answer_:**

**Frontend:**

```
<!DOCTYPE html>
<html>
    <head>
        <script
            src="https://code.jquery.com/jquery-3.3.1.js"
        ></script>
        <meta charset="utf-8">
        <title>Submit Form</title>
    </head>
    <body>
        <form action="./api/post.php" onsubmit="submitForm()">
            Choice A: <input type="text" name="choices[]"/>
            Choice B: <input type="text" name="choices[]"/>
            Choice C: <input type="text" name="choices[]"/>
            <input type="submit" value="Submit"/>
        </form>
        <p id="response"></p>
    </body>
    <script type="text/javascript">
    $(document).ready(() => {
        const requiredWord = "calculus";
        $("form").removeAttr("onsubmit");
        $("form").on('submit',(e) => {
            e.preventDefault();
            submitForm();
        });

        const submitForm = () => {
            const $form = $('form');
            const url = $('form').attr('action');
            validateInputs(url, $form);
            return false;
        }

        const runAjax = (url, $form) => {
            $.ajax({
                type: "POST",
                url: url,
                data: $form.serialize(),
                success: function (data) {
                    const json = JSON.parse(data);
                    $("#response").html(json.insert_log.status+"</br>");
                    $("#response").append(json.message+"</br>");
                    $("#response").append(json.controller_class+"</br>");
                }
            });

        }

        const validateInputs = (url, $form) => {
            const arr = $form.children("input[name='choices[]']");
            let calcIncluded = false;
            if(typeof arr === "undefined" || typeof arr != "object" || !arr){
                $("#response").html("Invalid information provided. Be sure to add Calculus");
            }

            arr.each((i, val) => {
                if(val.value.toLowerCase() === requiredWord.toLowerCase()){
                    calcIncluded = true;
                    runAjax(url,$form);
                }

                if(i === arr.length - 1 && !calcIncluded){
                    $("#response").html("Invalid input. Should not reach this statement.");
                }
            });
        }
    });
    </script>
</html>
```

**Backend:**
_post.php_

```
<?php
    include('../Controllers/Controller.php');
    $inputs = new Controller();
    $inputs->setKeyword("calculus");

    $log = array();
    $log["insert_log"] = NULL;


    if($inputs->validate($_POST["choices"])){
        $log["insert_log"] = $inputs->post();
    }


    $log["message"] = $inputs->getMessage();

    echo json_encode($log);
?>
```

_Controller.php_

```
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
```
