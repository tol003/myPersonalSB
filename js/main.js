function playMusic(id){

  currArtist = document.getElementById(id);
  music = currArtist.getElementsByTagName('audio')[0];

  if(music.paused){
    currArtist.getElementsByClassName('button-overlay')[0].style.backgroundImage = 'url(./site_images/pauseCircle.png)';
    music.currentTime = 0;
    music.play();
  }

  else{
    currArtist.getElementsByClassName('button-overlay')[0].style.backgroundImage = 'url(./site_images/playCircle.png)';
    music.pause();
  }
}