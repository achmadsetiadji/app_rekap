$(document).ready(function () {
    new Swiper(".swiper-promotion", {
      loop: true,
      slidesPerView: 2.5,
      centeredSlides: false,
      spaceBetween: 12,
      speed: 700,
      autoplay: {
        delay: 4700,
      },
    });
    new Swiper(".swiper-recently", {
      loop: false,
      slidesPerView: 2.3,
      centeredSlides: false,
      spaceBetween: 12,
      speed: 700,
      delay: 4700,
    });
    new Swiper(".slider-regular", {
      direction: "horizontal",
      loop: false,
      slidesPerView: "auto",
      spaceBetween: 15,
    });
    new Swiper(".swiper-content", {
      loop: false,
      slidesPerView: 1.5,
      centeredSlides: false,
      spaceBetween: 14,
      speed: 700,
      delay: 4700,
    });
    new Swiper(".swiper-onboard", {
      loop: false,
      slidesPerView: 1,
      centeredSlides: false,
      spaceBetween: 32,
      speed: 700,
      delay: 4700,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
    });
  });
  
  $(document).ready(function () {
    if (!$("body").hasClass("bottom-nav")) {
      var navHeight = $(".bottom-nav").outerHeight();
      $(".bottom-spacer").css("height", navHeight + "px");
    }
  
    $(".song-add").click(function () {
      alert("Success add this song to playlist");
      $(this).replaceWith(
        '<span class="icon-check-circle-fill song-added"></span>'
      );
    });
  
    // player config start
  
    const next = document.querySelector("#next");
    const play = document.querySelector("#play");
    const prev = document.querySelector("#prev");
    const progressBar = document.querySelector("#progress-bar");
    const musicTitle = document.querySelector(".music-name");
    const musicAlbum = document.querySelector(".music-album");
    const musicCard = document.querySelector(".music-card");
    const musicArtist = document.querySelector(".music-artist");
    const musicCover = document.querySelector(".music-image");
    const musicCurrentTime = document.querySelector("#musicTimeCurrent");
    const musicDurationTime = document.querySelector("#musicTimeDuration");
    const backgroundImage = document.querySelector("#backgroundImage");
    const music = document.querySelector("audio");
    const progressZone = document.querySelector(".music-progress");
  
    let isPlaying = false;
    // default select first music
    let selectedMusic = 1;
  
    play.addEventListener("click", () => {
      isPlaying ? pauseMusic() : playMusic();
    });
  
    const playList = [
      {
        artist: "Post Malone",
        cover:
          "https://yildirimzlm.s3.us-east-2.amazonaws.com/post-malone-2.jpeg",
        musicName: "Rockstar ft. 21 Savage",
        musicPath: `https://yildirimzlm.s3.us-east-2.amazonaws.com/Post+Malone+-+rockstar+ft.+21+Savage+(Official+Audio).mp3`,
        musicAlbum: "Stoney",
      },
      {
        artist: "Unlike Pluto",
        cover: "https://yildirimzlm.s3.us-east-2.amazonaws.com/unlike-pluto.jpeg",
        musicName: "No Scrubs ft. Joanna Jones",
        musicPath: `https://yildirimzlm.s3.us-east-2.amazonaws.com/Unlike+Pluto+-+No+Scrubs+ft.+Joanna+Jones+(Cover).mp3`,
        musicAlbum: "No Scrubs",
      },
      {
        artist: "Post Malone",
        cover: "https://yildirimzlm.s3.us-east-2.amazonaws.com/circles.jpeg",
        musicName: "Circles",
        musicPath: `https://yildirimzlm.s3.us-east-2.amazonaws.com/Post+Malone+-+Circles+(Lyrics).mp3`,
        musicAlbum: "Hollywood's Bleeding",
      },
    ];
  
    const playMusic = () => {
      music.play();
      document
        .querySelector(".music-control-play")
        .classList.replace("icon-player-play", "icon-player-pause");
      isPlaying = true;
      fadeInCover();
      musicCard.classList.add("middle-weight");
      setTimeout(() => {
        musicCard.classList.remove("middle-weight");
      }, 200);
    };
  
    const pauseMusic = () => {
      music.pause();
      document
        .querySelector(".music-control-play")
        .classList.replace("icon-player-pause", "icon-player-play");
      isPlaying = false;
      fadeInCover();
      musicCard.classList.add("middle-weight");
      setTimeout(() => {
        musicCard.classList.remove("middle-weight");
      }, 200);
    };
  
    const nextMusic = () => {
      selectedMusic = (selectedMusic + 1) % playList.length;
      loadMusic(playList[selectedMusic]);
      music.duration = 0;
      if (isPlaying) {
        music.play();
      }
      // musicCard.classList.add('right-weight');
      progressBar.style.width = `0%`;
      // setTimeout(() => {
      //     musicCard.classList.remove('right-weight');
      // }, 200)
    };
  
    const prevMusic = () => {
      selectedMusic = (selectedMusic - 1 + playList.length) % playList.length;
      loadMusic(playList[selectedMusic]);
      if (isPlaying) {
        music.play();
      }
      // musicCard.classList.add('left-weight');
      progressBar.style.width = `0%`;
      // setTimeout(() => {
      //     musicCard.classList.remove('left-weight');
      // }, 200)
    };
  
    const loadMusic = (playList) => {
      musicArtist.textContent = playList.artist;
      musicTitle.textContent = playList.musicName;
      musicAlbum.textContent = playList.musicAlbum;
      music.src = playList.musicPath;
      musicCover.src = `${playList.cover}`;
      backgroundImage.src = `${playList.cover}`;
      backgroundImage.animate(
        [
          {
            opacity: 0,
          },
          {
            opacity: 1,
          },
        ],
        {
          duration: 400,
        }
      );
      fadeInCover();
    };
  
    const fadeInCover = () => {
      musicCover.classList.add("animate");
      setTimeout(() => {
        musicCover.classList.remove("animate");
      }, 300);
    };
  
    // Update progress
    const updateProgress = (e) => {
      const { duration, currentTime } = e.srcElement;
      const progressPercent = (currentTime / duration) * 100;
      progressBar.style.width = `${progressPercent}%`;
  
      if (progressPercent == 100) {
        setTimeout(() => {
          nextMusic();
        }, 500);
      }
    };
  
    // Set progress
    function setProgress(e) {
      const width = this.clientWidth;
      const setPoint = e.offsetX;
      const duration = music.duration;
      music.currentTime = (setPoint / width) * duration;
    }
  
    // Set time area
    const setMusicTime = (e) => {
      const { duration, currentTime } = e.srcElement;
      calcSongTime(duration, musicDurationTime);
      calcSongTime(currentTime, musicCurrentTime);
    };
  
    const calcSongTime = (time, selectTime) => {
      time = Number(time);
      const m = Math.floor((time % 3600) / 60);
      const s = Math.floor((time % 3600) % 60);
      if (m < 10) {
        minute = "0" + m;
      } else minute = m;
      if (s < 10) {
        second = "0" + s;
      } else second = s;
  
      return (selectTime.textContent = `${minute}:${second}`);
    };
  
    next.addEventListener("click", nextMusic);
    prev.addEventListener("click", prevMusic);
    music.addEventListener("timeupdate", updateProgress);
    music.addEventListener("timeupdate", setMusicTime);
    progressZone.addEventListener("click", setProgress);
  
    function cardAnimate(e) {
      this.querySelectorAll(".music-card").forEach(function (boxMove) {
        const x = -(window.innerWidth / 3 - e.pageX) / 90;
        const y = (window.innerHeight / 3 - e.pageY) / 30;
        boxMove.style.transform = "rotateY(" + x + "deg) rotateX(" + y + "deg)";
      });
    }
  
    // player config end
  });
  
  // Gunakan jQuery untuk menangani peristiwa klik pada checkbox
  $(document).ready(function () {
    // Inisialisasi totalAmount
    var totalRegular = 0;
  
    // Fungsi untuk menampilkan atau menyembunyikan div berdasarkan nilai totalAmount dengan animasi fade
    function toggleResultContainer() {
      if (totalRegular === 0) {
        $("#resultPrice").fadeOut();
      } else {
        $("#resultPrice").fadeIn();
      }
    }
  
    // Ketika checkbox diubah
    var selectedRadio = $(".btn-check:checked");
    $(".btn-check").change(function () {
      // Jika checkbox dicentang, tambahkan 20.000 ke totalRegular
      var selectedRadio = $(".btn-check:checked");
      totalRegular = parseInt(selectedRadio.val(), 10);
  
      var formattedtotalRegular =
        "₭" + totalRegular.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  
      // Update nilai
      $("#totalRegular").text(formattedtotalRegular);
  
      toggleResultContainer();
    });
  });
  
  $(document).ready(function () {
    // Function to update the text
    function updateUnitText() {
      if ($("#btn-check").is(":checked")) {
        $(".kg-text").text("kg");
      } else if ($("#btn-check-2").is(":checked")) {
        $(".kg-text").text("lbs");
      }
    }
  
    // Trigger function when radio buttons are clicked
    $("#btn-check, #btn-check-2").on("change", updateUnitText);
  
    // Initial update
    updateUnitText();
  });
  
  $(document).ready(function () {
    // Function to update the text
    function updateUnitText() {
      if ($("#btn-cm").is(":checked")) {
        $(".cm-text").text("cm");
      } else if ($("#btn-cm-2").is(":checked")) {
        $(".cm-text").text("ft");
      }
    }
  
    // Trigger function when radio buttons are clicked
    $("#btn-cm, #btn-cm-2").on("change", updateUnitText);
  
    // Initial update
    updateUnitText();
  });
  
  // timer
  // --------Reveser-timer-----------
  if ($("#revese-timer").length) {
    const FULL_DASH_ARRAY = 283;
    const WARNING_THRESHOLD = 20;
    const ALERT_THRESHOLD = 15;
  
    const COLOR_CODES = {
      info: {
        color: "green",
      },
      warning: {
        color: "orange",
        threshold: WARNING_THRESHOLD,
      },
      alert: {
        color: "red",
        threshold: ALERT_THRESHOLD,
      },
    };
  
    var Minute = $("#revese-timer").data("minute");
    var Seconds = Math.round(60 * Minute);
    const TIME_LIMIT = Seconds;
    let timePassed = 0;
    let timeLeft = TIME_LIMIT;
    let timerInterval = null;
    let remainingPathColor = COLOR_CODES.info.color;
  
    // Update initial timer display
    document.getElementById("revese-timer").innerHTML = `
      <div class="base-timer">
        <svg class="base-timer__svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
          <g class="base-timer__circle">
            <circle class="base-timer__path-elapsed" cx="50" cy="50" r="45"></circle>
            <path
              id="base-timer-path-remaining"
              stroke-dasharray="283"
              class="base-timer__path-remaining ${remainingPathColor}"
              d="M 50, 50 m -45, 0 a 45,45 0 1,0 90,0 a 45,45 0 1,0 -90,0"
            ></path>
          </g>
        </svg>
        <span id="base-timer-label" class="base-timer__label">${formatTime(
          timeLeft
        )}</span>
      </div>
    `;
  
    let isTimerRunning = true; // Set timer status to running initially
  
    // Function to stop the timer
    function stopTimer() {
      clearInterval(timerInterval);
    }
  
    // Function to start the timer
    function startTimer() {
      timerInterval = setInterval(() => {
        timePassed += 1;
        timeLeft = TIME_LIMIT - timePassed;
        document.getElementById("base-timer-label").innerHTML =
          formatTime(timeLeft);
        setCircleDasharray();
        setRemainingPathColor(timeLeft);
  
        // If the timer is done, show the modal
        if (timeLeft <= 0) {
          clearInterval(timerInterval);
          showFinishModal(); // Show the finish modal when the timer ends
        }
      }, 1000);
    }
  
    // Function to show the finish modal
    function showFinishModal() {
      // Cek apakah halaman saat ini adalah 'time-rest.html'
      if (window.location.pathname.includes("time-rest.html")) {
        window.location.href = "chair-squat.html"; // Redirect ke chair-squat.html
      } else {
        // Jika bukan di 'time-rest.html', tampilkan modal
        $("#finish").modal("show");
      }
    }
  
    // Toggle the timer when stop/play button is pressed
    function toggleTimer() {
      if (isTimerRunning) {
        stopTimer();
        // Change icon to play
        $(".playing-plan.stop i")
          .removeClass("fi-rr-pause")
          .addClass("fi-rr-play");
      } else {
        startTimer();
        // Change icon to pause
        $(".playing-plan.stop i")
          .removeClass("fi-rr-play")
          .addClass("fi-rr-pause");
      }
      isTimerRunning = !isTimerRunning;
    }
  
    // Event listener for stop/play button
    $(".playing-plan.stop").on("click", function (e) {
      e.preventDefault();
      toggleTimer();
    });
  
    // Function to format time in MM:SS
    function formatTime(time) {
      const minutes = Math.floor(time / 60);
      let seconds = time % 60;
      if (seconds < 10) {
        seconds = `0${seconds}`;
      }
      return `${minutes}:${seconds}`;
    }
  
    // Function to set remaining path color based on time
    function setRemainingPathColor(timeLeft) {
      const { alert, warning, info } = COLOR_CODES;
      if (timeLeft <= alert.threshold) {
        document
          .getElementById("base-timer-path-remaining")
          .classList.remove(warning.color);
        document
          .getElementById("base-timer-path-remaining")
          .classList.add(alert.color);
      } else if (timeLeft <= warning.threshold) {
        document
          .getElementById("base-timer-path-remaining")
          .classList.remove(info.color);
        document
          .getElementById("base-timer-path-remaining")
          .classList.add(warning.color);
      }
    }
  
    // Function to calculate the fraction of time passed for the circle path
    function calculateTimeFraction() {
      const rawTimeFraction = timeLeft / TIME_LIMIT;
      return rawTimeFraction - (1 / TIME_LIMIT) * (1 - rawTimeFraction);
    }
  
    // Function to update the dasharray for the circle
    function setCircleDasharray() {
      const circleDasharray = `${(
        calculateTimeFraction() * FULL_DASH_ARRAY
      ).toFixed(0)} 283`;
      document
        .getElementById("base-timer-path-remaining")
        .setAttribute("stroke-dasharray", circleDasharray);
    }
  
    // Start the timer immediately when the page is loaded
    startTimer(); // Automatically start timer when page loads
  }