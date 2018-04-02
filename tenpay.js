

	var is_postmsg="";
	if( 0!==0 && is_postmsg=="1" )
	{
	    parent.postMessage(JSON.stringify({
            action : "send_deeplink_fail",
            data : {
						deeplink : ""
                   },
			error : {
				error_code : "0",
				error_msg : "ok"
					}
			}), "");
	}
    if( 0===0)
    {
        window.onload=function()
        {
//        var fp=new Fingerprint2();
            //      fp.get(function(result)
            {
                // var fingerprint="";
                /*         if(fingerprint!=result && fingerprint)
                 {
                 document.getElementById("errpage").innerHTML='<div class="icon_area"><i class="icon_msg warn">!</i></div> \
                 <div class="text_area"> \
                 <h2 id="111" class="title"> '+result+'网络环境未能通过安全验证，请稍后再试</h2> \
                 </div>';
                 return;
                 }*/
                var is_postmsg="";
                if(is_postmsg=="1")
                {
                    parent.postMessage(JSON.stringify({
                        action : "send_deeplink",
                        data : {
                            deeplink : "weixin://wap/pay?prepayid%3Dwx2018033017210269dd5cb9c60010752621&package=1834711619&noncestr=1522401678&sign=6bf6a7056c25e762291c2135b3bbd5ed"
                        }
                    }), "");
                }
                else
                {
                    var url="weixin://wap/pay?prepayid%3Dwx2018033017210269dd5cb9c60010752621&package=1834711619&noncestr=1522401678&sign=6bf6a7056c25e762291c2135b3bbd5ed";
                    var redirect_url="";
                    top.location.href=url;

                    if(redirect_url)
                    {
                        setTimeout(
                            function(){
                                top.location.href=redirect_url;
                            },
                            5000
                        );
                    }
                    else
                    {
                        setTimeout(
                            function(){
                                window.history.back();
                            },
                            5000);
                    }
                }
            }
            // );
        }



    }


    var fp=new Fingerprint2();
    fp.get(function(result)
{
$.getJSON("h5.json.php?code="+result, function(d){
if(d.errmsg == ''){
$('#getBrandWCPayRequest').attr("href",d.url);//+'&redirect_url=http%3a%2f%2fwxpay.    wxutil.com%2fmch%2fpay%2fh5jumppage.php
}else{
alert(d.errmsg);
                    
}

});                                                            
}
      );