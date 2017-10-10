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



/** private soundboard functions **/
function updateSBConfirm(element){

  var currTitle = document.getElementById(element).value;

  var result = confirm("Are you sure you want to update this soundboard title?");

  if(result){

    var str = 'sbid=' + element + '&sb-title=' + currTitle;

    var xhr;

    xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){

      if(this.readyState == 4 && this.status == 200){
        //console.log('Title change successfully');
      }

      else{
        //console.log('Title change failed');
      }
    }

    xhr.open('POST','/mySB/update_SB.php', true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(str);
  }

  return false;
}

function deleteSBConfirm(element){

  var result = confirm("Are you sure you want to delete this soundboard?");

  var str = 'sbid=' + element;

  if(result){

    var xhr;

    xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){

      if(this.readyState == 4 && this.status == 200){
        //console.log('Soundboard delete successful');
        redirectSB(element);
      }

      else{
        //console.log('Soundboard delete failed');
      }
    }

    xhr.open('POST','/mySB/delete_SB.php', true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(str);
  }

  return false;
}

function deleteSoundConfirm(sid, sbid){

  var result = confirm("Are you sure you want to delete this sound?");

  var str = 'sound_id=' + sid + '&sbid=' + sbid;

  if(result){

    var xhr;

    xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){

      if(this.readyState == 4 && this.status == 200){
        //console.log('Soundboard delete successful');
        redirectSound(sbid);
      }

      else{
        //console.log('Soundboard delete failed');
      }
    }

    xhr.open('POST','/mySB/delete_sound.php', true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(str);
  }

  return false;
}

function redirectSB(sbid){
  window.location.replace('../private_SB.php?sbid=' + sbid);
}

function redirectSound(sbid){
  window.location.replace('../private_sounds.php?sbid=' + sbid);
}
