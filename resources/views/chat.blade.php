<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


    </head>
    <body>
        <div class="container">


            <div class="row">
                <div class="col-12">
                    <form action="messageUpdateTable" method="get">
                        <div class="form-group">
                            <label class="label" id="messagesID">Username: {{$username}}</label>
                        </div>
                        <div class="form-group">
                            <h5>Messages</h5>
                            <textarea id="messagesInput" name="messagesInput"></textarea>
                        </div>
                        <div class="form-group">
                            <table id="messagesFeed" class="table table-bordered">
                                <tr>
                                    <td>ardie</td>
                                    <td>some message</td>
                                    <td>time</td>
                                </tr>
                            </table>
                            <!-- <label id="messagesFeed">messages</label> -->
                        </div>
                        <div class="form-group">
                            <input type="submit" value="send message" />
                        </div>


                    </form>
                </div>

            </div>

        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script> 
        <script type="text/javascript">

	       function poll() {
		         var ajax = new XMLHttpRequest();
		         ajax.onreadystatechange = function() {
			           if (this.readyState === 4 && this.status === 200) {
				             if (this.status === 200) {
                         //REMOVE
					               /* try {
						                var json = JSON.parse(this.responseText);
					                  } catch {
						                poll();
                          *     return;
					                  } */
                         // console.log(this.responseText);
                         // console.log("200");


					               /* if (json.status !== true) {
						                alert(json.error);return;
					                  } */

                         var jsonMessages = JSON.parse(this.responseText);



                         var messagesFeed = $('#messagesFeed');

                         var elementRows = '<tr><th>username</th><th>message</th><th>time sent</th></tr>';
                         jsonMessages.forEach(function (item){
                             // messagesFeed.append('<br>'+'username'+'--'+item.message+'--'+'time');
                             var elementNew = '<tr><td>'+item.username+'</td><td>'+item.message+'</td><td>'+item.time+'</td></tr>';
                             elementRows = elementRows + elementNew;

                         })
                         messagesFeed.html(elementRows);


                         /* $('#messagesFeed').append('<br>'); */


					               /* var div = document.createElement("DIV");
					                  document.body.appendChild(div);
					                  div.innerHTML = 'time: '   json.time   ', content: '   json.content;*/
					               poll(); 
				             } else {
					               poll();
                         console.log("else");
				             }
			           }
		         }
             var stringg = "{{$username}}";
             ajax.open('GET', '/long-polling?username='+stringg, true);
             var username = $('#messagesID')
		         ajax.send();
	       }
	       poll();
        </script>
    </body>
</html>
