function updateClock() {
    var now = new Date();
    var hours = now.getHours();
    var minutes = now.getMinutes();
    var seconds = now.getSeconds();
  
    // Add leading zeros to minutes and seconds
    minutes = (minutes < 10 ? "0" : "") + minutes;
    seconds = (seconds < 10 ? "0" : "") + seconds;
  
    // Determine AM or PM string
    var timeOfDay = (hours < 12) ? "AM" : "PM";
  
    // Convert hours to 12-hour format
    hours = (hours > 12) ? hours - 12 : hours;
  
    // Convert hours of 0 to 12
    hours = (hours == 0) ? 12 : hours;
  
    // Format the clock time
    var currentTime = hours + ":" + minutes + ":" + seconds + " " + timeOfDay;
  
    // Update the clock on the page
    document.getElementById("clock").innerHTML = currentTime;
  }
  
  setInterval(updateClock, 1000);