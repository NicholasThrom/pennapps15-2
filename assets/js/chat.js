document.getElementById("output").scrollTop = document.getElementById("output").scrollHeight;

document.onkeydown = function (event)
{
    switch (event.keyCode)
    {
        case 13:
            $.ajax({
                url: base_url + "index.php/main/addMessage",
                type: "post",
                data: {n: name, c: document.getElementById("input").value, u: user}
            });

            document.getElementById("input").value = "";

            break;
    }
};


function update ()
{
    $.ajax({
        url: base_url + "index.php/main/receiveMessage",
        type: "post",
        data: {n: name, i: i},
        dataType: "json",
        success: function (data) {
            for (var j = 0; j < data.length; j++)
            {
                document.getElementById("output").innerHTML += "<br/>" + data[j].user + ": " + data[j].content;
                i = data[j].id_message;
                document.getElementById("output").scrollTop = document.getElementById("output").scrollHeight;
            }
            update();
        }
    });
}

update();

document.getElementById("input").value;
