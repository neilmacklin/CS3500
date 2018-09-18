
$("document").ready(function(){ 
        $(".img1").mouseenter(function(){       
            $(this).attr('src','images/p1/hovered/05030_big.jpg');
            $(this).css("width", "100px");      
        });     
        $(".img1").mouseleave(function(){       
            $(this).attr('src','images/p1/05030.jpg');
            $(this).css("width", "auto");      
        });

        $(".img2").mouseenter(function(){       
            $(this).attr('src','images/p1/hovered/120010_big.jpg');
            $(this).css("width", "100px");      
        });     
        $(".img2").mouseleave(function(){       
            $(this).attr('src','images/p1/120010.jpg');      
            $(this).css("width", "auto");
        }); 

        $(".img3").mouseenter(function(){       
            $(this).attr('src','images/p1/hovered/07020_big.jpg');      
            $(this).css("width", "100px");
        });     
        $(".img3").mouseleave(function(){       
            $(this).attr('src','images/p1/07020.jpg');
            $(this).css("width", "auto");      
        }); 

        $(".img4").mouseenter(function(){       
            $(this).attr('src','images/p1/hovered/13030_big.jpg');
            $(this).css("width", "100px");      
        });     
        $(".img4").mouseleave(function(){       
            $(this).attr('src','images/p1/13030.jpg'); 
            $(this).css("width", "auto");     
        }); 

        $(".img5").mouseenter(function(){       
            $(this).attr('src','images/p1/hovered/06010_big.jpg');
            $(this).css("width", "100px");      
        });     
        $(".img5").mouseleave(function(){       
            $(this).attr('src','images/p1/06010.jpg');
            $(this).css("width", "auto");      
        });  
});
