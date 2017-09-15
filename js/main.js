function playMusic(id){

  currArtist = document.getElementById(id);
  music = currArtist.getElementsByTagName('audio')[0];

  if(music.paused){
    currArtist.getElementsByClassName('button-overlay')[0].style.backgroundImage = 'url(../site-images/pauseCircle.png)';
    music.currentTime = 0;
    music.play();

$.ajax({
         type: "GET",
         url: "log.php",
         data: {
               "sid":id
               }
        });
       /* success: function(data) {
                  alert(data);
                 console.log(5 + 6);

                                   }
                     });*/

  }

  else{
    currArtist.getElementsByClassName('button-overlay')[0].style.backgroundImage = 'url(../site-images/playCircle.png)';
    music.pause();
  }
}