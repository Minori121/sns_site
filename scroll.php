<!DOCTYPE html>
<html>
    <head>
        <script src='https://code.jquery.com/jquery-3.5.1.min.js'></script>
        <script>
            $(function(){

                var h = $(window).height();
                for(var i=0;i<h/100;i++){
                    get_img(i);
                }

                $(window).scroll(function(){
                    var btm= $(this).scrollTop()+h;
                    if(btm>i*100){
                        i++;
                        get_img(i);
                    }
                })

                function get_img(number){
                    $.ajax({
                        url:'put_img.php',
                        async:false,
                        type:'POST',
                        data:{number: number},
                        success:function(data){
                            var box=$(data);
                            $('article').append(data);
                        }
                    })
                }
            })
        </script>

        <style>
            .box{
                width:100px;
                height:100px;
                background-color:pink;
                border:solid 2px blue;
                margin:10px;
            }
        </style>
    </head>
    <body>
        <article>

        </article>

    </body>
</html>
