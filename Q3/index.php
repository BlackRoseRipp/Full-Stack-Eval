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
        <form action="post.php" onsubmit="submitForm();return false;">
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
        // $form.removeAttr("action");
            validateInputs(url, $form);
            return false;
        }

        const runAjax = (url, $form) => {
            $.ajax({
                type: "POST",
                url: url,
                data: $form.serialize(), // serializes the form's elements.
                success: function (data) {
                    const json = JSON.parse(data); // show response from the php script.
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