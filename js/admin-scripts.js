document.addEventListener("DOMContentLoaded", function () {
  const title = document.querySelector(".cdr-dashboard-title");

  function triggerAnimation() {
      title.style.animation = "fadeInBounce 4.5s ease-out forwards, glowEffect 5s infinite alternate";
      
      setTimeout(() => {
          title.style.animation = "none"; // Reset animation
      }, 3000);

      setTimeout(triggerAnimation, 5000); // Repeat every 5 seconds
  }

  triggerAnimation();
});
