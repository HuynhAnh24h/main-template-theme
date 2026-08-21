// JS dành riêng cho trang chủ (Home Page)
document.addEventListener("DOMContentLoaded", () => {
  console.log("Home Page Script Loaded!");

 
  // ---- Slider: nghiêng sản phẩm theo chuột ----
  (function () {
    var stage = document.getElementById("home-product-stage");
    var visual = document.querySelector(".home__visual");
    if (!stage || !visual) return;

    visual.addEventListener("mousemove", function (e) {
      var r = visual.getBoundingClientRect();
      var px = (e.clientX - r.left) / r.width - 0.5;
      var py = (e.clientY - r.top) / r.height - 0.5;
      stage.style.transform =
        "rotateY(" + px * 18 + "deg) rotateX(" + -py * 14 + "deg)";
    });

    visual.addEventListener("mouseleave", function () {
      stage.style.transform = "rotateY(0deg) rotateX(0deg)";
    });
  })();

  // ---- Main Slider: Carousel Logic ----
  (function () {
    const slider = document.getElementById("home-main-slider");
    if (!slider) return;

    const wrapper = slider.querySelector(".slider-wrapper");
    const slides = slider.querySelectorAll(".slide");
    const prevBtn = document.getElementById("slider-prev");
    const nextBtn = document.getElementById("slider-next");
    const dots = slider.querySelectorAll(".slider-dot");

    if (slides.length <= 1) return;

    let currentIndex = 0;
    const slideCount = slides.length;
    let autoPlayTimer = null;

    function updateSlider() {
      // Dịch chuyển wrapper theo chiều ngang
      wrapper.style.transform = `translateX(-${currentIndex * 100}%)`;

      // Cập nhật trạng thái hiển thị của các nút chỉ mục (dots)
      dots.forEach((dot, index) => {
        if (index === currentIndex) {
          dot.classList.add("bg-white", "w-6");
          dot.classList.remove("bg-white/35", "w-2.5");
        } else {
          dot.classList.add("bg-white/35", "w-2.5");
          dot.classList.remove("bg-white", "w-6");
        }
      });
    }

    function nextSlide() {
      currentIndex = (currentIndex + 1) % slideCount;
      updateSlider();
    }

    function prevSlide() {
      currentIndex = (currentIndex - 1 + slideCount) % slideCount;
      updateSlider();
    }

    // Sự kiện nút điều hướng
    if (nextBtn) {
      nextBtn.addEventListener("click", () => {
        nextSlide();
        resetAutoPlay();
      });
    }

    if (prevBtn) {
      prevBtn.addEventListener("click", () => {
        prevSlide();
        resetAutoPlay();
      });
    }

    // Sự kiện click chọn chỉ mục (dots)
    dots.forEach((dot, index) => {
      dot.addEventListener("click", () => {
        currentIndex = index;
        updateSlider();
        resetAutoPlay();
      });
    });

    // Tự động chuyển Slide
    function startAutoPlay() {
      autoPlayTimer = setInterval(nextSlide, 5000); // 5 giây chuyển ảnh
    }

    // Dừng chuyển Slide
    function stopAutoPlay() {
      if (autoPlayTimer) clearInterval(autoPlayTimer);
    }

    // Reset chạy tự động
    function resetAutoPlay() {
      stopAutoPlay();
      startAutoPlay();
    }

    // Khởi động ban đầu
    updateSlider();
    startAutoPlay();

    // Tạm dừng khi rê chuột vào, tự động chạy tiếp khi rê chuột ra ngoài
    slider.addEventListener("mouseenter", stopAutoPlay);
    slider.addEventListener("mouseleave", startAutoPlay);
  })();
});