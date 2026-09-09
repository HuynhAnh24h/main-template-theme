// JS dành riêng cho trang chủ (Home Page) - 4-Stage Luxury Loading & Reveal (On The Rock)
function initWanderLoader() {
  console.log("On The Rock 4-Stage Home Loader Initializing...");

  const loader       = document.getElementById('loader');
  const stage1Logo   = document.getElementById('loader-stage1');
  const stage2Wrap   = document.getElementById('loader-stage2');
  const stackWrap    = document.getElementById('stackWrap');
  const progressWrap = document.getElementById('loader-progress-wrap');
  const progressBar  = document.getElementById('progressBar');
  const pctNum       = document.getElementById('pctNum');
  const stage3Logo   = document.getElementById('loader-stage3-logo');
  const board        = document.getElementById('board');
  const homeQuote    = document.getElementById('home-quote');

  // Đọc danh sách ảnh truyền từ WordPress qua biến toàn cục (10 ảnh)
  const rawImages = window.WanderConfig?.images || [];
  const IMAGES = Array.isArray(rawImages) && rawImages.length > 0 ? rawImages.slice(0, 10) : [];

  // Failsafe nếu không có ảnh hoặc loader không tồn tại
  if (!loader || IMAGES.length === 0) {
    document.body.classList.add('is-loaded');
    if (homeQuote) homeQuote.classList.add('reveal');
    if (loader) loader.remove();
    return;
  }

  const vw = () => window.innerWidth;
  const vh = () => window.innerHeight;
  const isMobile = () => window.innerWidth < 768;

  // Tọa độ 10 ảnh ở Giai đoạn 3 (Desktop): Tỏa ra viền màn hình khớp 100% hình mockup
  const DESKTOP_STAGE3_LAYOUT = [
    { left: 0,    top: 1.5,  w: 11.5, h: 32,   rot: -3 }, // 1: Ly rượu chân cao góc trên trái
    { left: 19.5, top: 8.5,  w: 14,   h: 33.5, rot: -5 }, // 2: Cặp quả cầu disco lệch trái trên
    { left: 40.5, top: 0,    w: 14,   h: 16,   rot: 0  }, // 3: Bartender pha cocktail xanh giữa trên
    { left: 60,   top: 12,   w: 15.5, h: 32.5, rot: 6  }, // 4: Bạn nữ bên vách kính lệch phải trên
    { left: 86.5, top: 3.5,  w: 13.5, h: 31,   rot: -4 }, // 5: Nâng ly cocktail góc trên phải
    { left: 0,    top: 76,   w: 11,   h: 24,   rot: 5  }, // 6: Chai bourbon góc dưới trái
    { left: 11.5, top: 49,   w: 15.5, h: 32,   rot: 3  }, // 7: Ly martini bàn tròn đen giữa trái
    { left: 34.5, top: 66,   w: 14.5, h: 30,   rot: -4 }, // 8: Hai người chơi cờ vua góc dưới trái
    { left: 64.5, top: 62.5, w: 14,   h: 29,   rot: 0  }, // 9: Bàn cocktail & nến góc dưới phải
    { left: 86.5, top: 65,   w: 13.5, h: 30,   rot: 4  }  // 10: Menu cocktail góc dưới phải
  ];

  // Tọa độ 10 ảnh ở Giai đoạn 3 (Mobile): Viền tròn cân đối ôm lấy Logo trung tâm
  const MOBILE_STAGE3_LAYOUT = [
    { left: -2, top: 2,  w: 86, h: 124, rot: -5 },
    { left: 72, top: 2,  w: 86, h: 124, rot: 5  },
    { left: 35, top: 0,  w: 88, h: 95,  rot: 0  },
    { left: -6, top: 36, w: 84, h: 118, rot: 4  },
    { left: 78, top: 36, w: 84, h: 118, rot: -4 },
    { left: -2, top: 72, w: 86, h: 124, rot: -4 },
    { left: 72, top: 72, w: 86, h: 124, rot: 4  },
    { left: 35, top: 82, w: 88, h: 100, rot: 0  },
    { left: 16, top: 54, w: 84, h: 115, rot: 3  },
    { left: 54, top: 54, w: 84, h: 115, rot: -3 }
  ];

  const getTargetPos = (layout) => {
    if (isMobile()) {
      return {
        x: (layout.left / 100) * vw(),
        y: (layout.top / 100) * vh(),
        w: layout.w,
        h: layout.h,
        rot: layout.rot
      };
    }
    return {
      x: (layout.left / 100) * vw(),
      y: (layout.top / 100) * vh(),
      w: (layout.w / 100) * vw(),
      h: (layout.h / 100) * vh(),
      rot: layout.rot
    };
  };

  // Góc nghiêng xấp bài ở Stage 2
  const STACK_OFFSET = [
    { x:-7, y: 5,  rot:-9 },
    { x: 6, y:-4,  rot: 7 },
    { x:-4, y:-7,  rot:-5 },
    { x: 8, y: 6,  rot: 11 },
    { x:-9, y: 2,  rot:-12 },
    { x: 4, y:-8,  rot: 6 },
    { x:-3, y: 8,  rot:-7 },
    { x: 9, y:-5,  rot: 10 },
    { x:-8, y:-3,  rot:-10 },
    { x: 3, y: 7,  rot: 5 }
  ];

  let currentStep = 0;
  const totalSteps = Math.min(10, IMAGES.length);
  const stepTime = 230; // Chậm rãi và mượt mà hơn (~2.3s cho 10 ảnh)
  let isDone = false;

  // ================= BẮT ĐẦU GIAI ĐOẠN 1 (Logo Trung Tâm To Rõ) =================
  if (stage1Logo) {
    stage1Logo.classList.add('stage-active');
  }

  // Giữ Logo trang đầu trong 1400ms để người xem cảm nhận thương hiệu
  setTimeout(() => {
    if (isDone) return;
    if (stage1Logo) {
      stage1Logo.classList.remove('stage-active');
      stage1Logo.classList.add('stage-exit');
    }
    setTimeout(() => {
      if (isDone) return;
      if (stage2Wrap) {
        stage2Wrap.classList.add('stage-active');
      }
      // Bắt đầu quăng bài Stage 2
      setTimeout(loadStep, 150);
    }, 200);
  }, 1400);

  // ================= GIAI ĐOẠN 2: QUĂNG XẤP BÀI VÀO GIỮA =================
  function loadStep() {
    if (isDone) return;
    currentStep++;
    const percent = Math.min(100, Math.round((currentStep / totalSteps) * 100));
    if (pctNum) pctNum.textContent = percent + '%';
    if (progressBar) progressBar.style.width = percent + '%';

    const off = STACK_OFFSET[(currentStep - 1) % STACK_OFFSET.length];
    const card = document.createElement('div');
    card.className = 'photo';
    card.style.backgroundImage = `url('${IMAGES[currentStep - 1]}')`;
    card.style.zIndex = currentStep;
    if (stackWrap) stackWrap.appendChild(card);

    const mobile = isMobile();
    const fromSide = (currentStep % 2 === 0) ? 1 : -1;
    const fromX = fromSide * (mobile ? 90 : 180);
    const fromY = (mobile ? -30 : -55) + Math.random() * 25;
    const fromRot = fromSide * (mobile ? 40 : 60);
    const scaleOff = mobile ? 0.75 : 1;
    const targetX = off.x * scaleOff;
    const targetY = off.y * scaleOff;

    if (card.animate) {
      card.animate([
        { transform: `translate3d(${fromX}px, ${fromY}px, 0) rotate(${fromRot}deg) scale(0.8)`, opacity: 0 },
        { transform: `translate3d(${targetX * 0.4}px, ${targetY * 0.4}px, 0) rotate(${off.rot * 1.2}deg) scale(1.03)`, opacity: 1, offset: 0.6 },
        { transform: `translate3d(${targetX}px, ${targetY}px, 0) rotate(${off.rot}deg) scale(1)`, opacity: 1 }
      ], {
        duration: 480,
        easing: 'cubic-bezier(0.16, 1, 0.3, 1)',
        fill: 'forwards'
      });
    } else {
      card.style.transform = `translate3d(${targetX}px, ${targetY}px, 0) rotate(${off.rot}deg)`;
      card.style.opacity = '1';
    }

    if (currentStep < totalSteps) {
      setTimeout(loadStep, stepTime);
    } else {
      // Đã nạp 100% -> Dừng nghỉ 380ms để người xem thấy 100% trọn vẹn rồi bung ảnh
      setTimeout(startStage3, 380);
    }
  }

  // ================= GIAI ĐOẠN 3: BUNG TỎA RA VIỀN MÀN HÌNH =================
  function startStage3() {
    if (isDone) return;

    // Chuyển background loader sang trong suốt để ảnh bung thẳng lên nền #intro-brown-bg của #section-intro
    if (loader) {
      loader.style.backgroundColor = 'transparent';
    }

    // 1. Ẩn toàn bộ khối Stage 2 (xấp ảnh + thanh tiến trình) êm ái
    if (stage2Wrap) {
      stage2Wrap.classList.remove('stage-active');
      stage2Wrap.classList.add('stage-exit');
    }
    if (progressWrap) {
      progressWrap.style.opacity = '0';
    }
    if (stackWrap) {
      stackWrap.style.transition = 'opacity 350ms ease';
      stackWrap.style.opacity = '0';
    }

    // 2. Hiện Logo OTR ở tâm điểm Giai đoạn 3
    if (stage3Logo) {
      setTimeout(() => {
        stage3Logo.classList.add('stage-active');
      }, 100);
    }

    const mobile = isMobile();
    const activeLayout = mobile ? MOBILE_STAGE3_LAYOUT : DESKTOP_STAGE3_LAYOUT;
    const originX = vw() / 2 - (mobile ? 70 : 92);
    const originY = vh() / 2 - (mobile ? 95 : 128);

    IMAGES.forEach((src, idx) => {
      const target = getTargetPos(activeLayout[idx % activeLayout.length]);
      const tile = document.createElement('div');
      tile.className = 'tile';
      tile.style.backgroundImage = `url('${src}')`;
      tile.style.width = target.w + 'px';
      tile.style.height = target.h + 'px';
      tile.style.left = originX + 'px';
      tile.style.top = originY + 'px';
      if (board) board.appendChild(tile);

      const dx = target.x - originX;
      const dy = target.y - originY;

      const arcSide = (idx % 2 === 0 ? 1 : -1);
      const arcBend = (mobile ? 40 : 80) + Math.random() * (mobile ? 30 : 60);
      const midX = dx * 0.5 + arcSide * arcBend * (dy >= 0 ? 0.35 : -0.35);
      const midY = dy * 0.5 - ((mobile ? 50 : 100) + Math.random() * (mobile ? 25 : 50));
      const flipRot = target.rot + arcSide * (mobile ? 50 : 100) + Math.random() * (mobile ? 30 : 60);
      const delay = (mobile ? 30 : 50) + idx * (mobile ? 40 : 60);

      if (tile.animate) {
        tile.animate([
          { transform: `translate3d(0px, 0px, 0) rotate(0deg) scale(0.35)`, opacity: 0, offset: 0 },
          { transform: `translate3d(${midX * 0.38}px, ${midY * 0.38}px, 0) rotate(${flipRot * 0.3}deg) scale(0.85)`, opacity: 1, offset: 0.22 },
          { transform: `translate3d(${midX}px, ${midY}px, 0) rotate(${flipRot}deg) scale(1.05)`, opacity: 1, offset: 0.58 },
          { transform: `translate3d(${dx * 0.96}px, ${dy * 0.96}px, 0) rotate(${target.rot * 0.95}deg) scale(1.01)`, opacity: 1, offset: 0.88 },
          { transform: `translate3d(${dx}px, ${dy}px, 0) rotate(${target.rot}deg) scale(1)`, opacity: 1, offset: 1 }
        ], {
          duration: mobile ? 1450 : 1750,
          delay: delay,
          easing: 'cubic-bezier(0.16, 1, 0.3, 1)',
          fill: 'forwards'
        });
      } else {
        tile.style.transform = `translate3d(${dx}px, ${dy}px, 0) rotate(${target.rot}deg)`;
        tile.style.opacity = '1';
      }
    });

    // Giữ màn hình Giai đoạn 3 trong khoảng 2.2s để người xem thưởng thức trọn vẹn bố cục
    setTimeout(startStage4, 2200);
  }

  // ================= GIAI ĐOẠN 4: CHUYỂN SANG MÀN NHUNG ĐEN & CÂU QUOTE (ẢNH STAGE 3 Ở LẠI LÀM NỀN) =================
  function startStage4() {
    if (isDone) return;
    isDone = true;

    // 1. Kích hoạt chuyển cảnh mượt mà ở Section Intro:
    // - Nền nâu #intro-brown-bg mờ dần, chuyển sang nền nhung đen
    // - 10 ảnh ở Stage 3 ở lại làm Background nghệ thuật cho Section Intro
    // - Lớp phủ Vignette #intro-wash hiện lên nhẹ nhàng để tôn câu slogan
    const introSection = document.getElementById('section-intro');
    if (introSection) {
      introSection.classList.add('is-revealed');
    }

    // 2. Làm mờ nhẹ nhàng Logo Stage 3 ở trung tâm
    if (stage3Logo) {
      stage3Logo.classList.remove('stage-active');
      stage3Logo.classList.add('stage-exit');
    }

    // 3. Kích hoạt hiệu ứng xuất hiện cho câu quote ở Stage 4
    if (homeQuote) {
      homeQuote.classList.add('reveal');
    }

    // 4. Mờ dần khung loader cố định và ẩn đi sau 2.0s
    if (loader) {
      loader.classList.add('is-fading');
      setTimeout(() => {
        if (loader) loader.style.display = 'none';
      }, 2000);
    }

    // 5. Mở khóa cuộn trang
    document.body.classList.add('is-loaded');
  }

  // Failsafe Timeout: Tối đa 8.5s tự động mở khóa
  setTimeout(() => {
    if (!isDone) {
      startStage4();
    }
  }, 8500);
}

function initHomePageFeatures() {
  // Lắng nghe cuộn trang tối ưu hiệu năng (60-120fps) với Liquid Glass Header & Fixed Parallax
  const siteHeader     = document.getElementById('site-header');
  const heroBgParallax = document.querySelector('.hero-bg-parallax');
  const parallaxMedia  = document.querySelectorAll('[data-parallax]');

  let isTicking = false;
  const updateScrollPipeline = () => {
    const scrollY = window.scrollY || document.documentElement.scrollTop || 0;

    // 1. Kích hoạt Liquid Glass cho Header
    if (siteHeader) {
      if (scrollY > 30) {
        siteHeader.classList.add('liquid-glass', 'is-scrolled');
      } else {
        siteHeader.classList.remove('liquid-glass', 'is-scrolled');
      }
    }

    // 2. Hiệu ứng Fixed Parallax cho ảnh nền Hero (trôi êm ái 0.35x tạo độ sâu điện ảnh)
    if (heroBgParallax && scrollY < window.innerHeight * 1.5) {
      const heroOffset = scrollY * 0.35;
      heroBgParallax.style.transform = `translate3d(0, ${heroOffset}px, 0)`;
    }

    // 3. Hiệu ứng Fixed Parallax nhẹ nhàng cho các hình ảnh trong trang (Chỉ chạy trên Desktop/Tablet để tối ưu 120fps cho Mobile)
    if (window.innerWidth >= 768 && parallaxMedia.length > 0) {
      const winH = window.innerHeight;
      parallaxMedia.forEach((media) => {
        const rect = media.getBoundingClientRect();
        if (rect.top < winH && rect.bottom > 0) {
          const progress = (rect.top + rect.height / 2 - winH / 2) / winH;
          const translateY = progress * -20;
          media.style.transform = `scale(1.06) translate3d(0, ${translateY}px, 0)`;
        }
      });
    }

    isTicking = false;
  };

  const onWindowScroll = () => {
    if (!isTicking) {
      window.requestAnimationFrame(updateScrollPipeline);
      isTicking = true;
    }
  };

  window.addEventListener('scroll', onWindowScroll, { passive: true });
  updateScrollPipeline();

  // Khởi tạo bộ điều khiển Testimonials Slider (Tự động chuyển slide 3s & Điều hướng)
  const testiTrack = document.getElementById('testimonials-track');
  const testiPrevBtns = document.querySelectorAll('.testi-prev-btn, #testi-prev-btn');
  const testiNextBtns = document.querySelectorAll('.testi-next-btn, #testi-next-btn');
  const testiDots = document.querySelectorAll('.testi-dot');

  if (testiTrack) {
    const getSlideWidth = () => {
      const firstSlide = testiTrack.querySelector('.testi-slide');
      return firstSlide ? firstSlide.offsetWidth : 320;
    };

    // Hàm cập nhật trạng thái Dots chỉ báo
    const updateDots = () => {
      const slideWidth = getSlideWidth();
      if (slideWidth <= 0 || testiDots.length === 0) return;
      const currentIndex = Math.round(testiTrack.scrollLeft / slideWidth);
      testiDots.forEach((dot, idx) => {
        if (idx === currentIndex) {
          dot.classList.add('is-active', '!w-6', '!bg-[#caa875]', '!rounded-[4px]');
          dot.classList.remove('bg-[#caa875]/30');
        } else {
          dot.classList.remove('is-active', '!w-6', '!bg-[#caa875]', '!rounded-[4px]');
          dot.classList.add('bg-[#caa875]/30');
        }
      });
    };

    // Hàm chuyển sang slide kế tiếp (tự động quay vòng về đầu khi hết slide)
    const nextSlide = () => {
      const slideWidth = getSlideWidth();
      const maxScroll = testiTrack.scrollWidth - testiTrack.clientWidth;
      if (testiTrack.scrollLeft >= maxScroll - 15) {
        testiTrack.scrollTo({ left: 0, behavior: 'smooth' });
      } else {
        testiTrack.scrollBy({ left: slideWidth, behavior: 'smooth' });
      }
    };

    // Hàm lùi về slide trước
    const prevSlide = () => {
      const slideWidth = getSlideWidth();
      if (testiTrack.scrollLeft <= 15) {
        const maxScroll = testiTrack.scrollWidth - testiTrack.clientWidth;
        testiTrack.scrollTo({ left: maxScroll, behavior: 'smooth' });
      } else {
        testiTrack.scrollBy({ left: -slideWidth, behavior: 'smooth' });
      }
    };

    // Tự động chuyển slide mỗi khoảng 3s theo yêu cầu của bạn
    let autoSlideInterval = null;
    let resumeTimeout = null;

    const startAutoSlide = () => {
      stopAutoSlide();
      autoSlideInterval = setInterval(nextSlide, 3000);
    };

    const stopAutoSlide = () => {
      if (autoSlideInterval) {
        clearInterval(autoSlideInterval);
        autoSlideInterval = null;
      }
      if (resumeTimeout) {
        clearTimeout(resumeTimeout);
        resumeTimeout = null;
      }
    };

    const restartAutoSlideDelayed = (delayMs = 2500) => {
      stopAutoSlide();
      resumeTimeout = setTimeout(startAutoSlide, delayMs);
    };

    // Bắt đầu chạy tự động
    startAutoSlide();

    // Gắn sự kiện cho các nút Prev / Next (cả Desktop và Mobile)
    testiNextBtns.forEach((btn) => {
      btn.addEventListener('click', () => {
        nextSlide();
        restartAutoSlideDelayed(3500);
      });
    });

    testiPrevBtns.forEach((btn) => {
      btn.addEventListener('click', () => {
        prevSlide();
        restartAutoSlideDelayed(3500);
      });
    });

    // Gắn sự kiện click cho các Dots
    testiDots.forEach((dot) => {
      dot.addEventListener('click', () => {
        const targetIdx = parseInt(dot.getAttribute('data-index') || '0', 10);
        const slideWidth = getSlideWidth();
        testiTrack.scrollTo({ left: targetIdx * slideWidth, behavior: 'smooth' });
        restartAutoSlideDelayed(3500);
      });
    });

    // Lắng nghe sự kiện cuộn để đồng bộ Dots
    testiTrack.addEventListener('scroll', () => {
      updateDots();
    }, { passive: true });

    // Tạm dừng tự động khi rê chuột vào hoặc khi người dùng đang xem
    testiTrack.addEventListener('mouseenter', stopAutoSlide);
    testiTrack.addEventListener('mouseleave', () => restartAutoSlideDelayed(1500));

    // Hỗ trợ chạm vuốt trên Mobile / Tablet
    testiTrack.addEventListener('touchstart', stopAutoSlide, { passive: true });
    testiTrack.addEventListener('touchend', () => restartAutoSlideDelayed(2500), { passive: true });

    // Hỗ trợ kéo lướt bằng chuột (Mouse Drag)
    let isDown = false;
    let startX = 0;
    let scrollStart = 0;

    testiTrack.addEventListener('mousedown', (e) => {
      isDown = true;
      stopAutoSlide();
      startX = e.pageX - testiTrack.offsetLeft;
      scrollStart = testiTrack.scrollLeft;
    });

    testiTrack.addEventListener('mouseleave', () => { isDown = false; });
    testiTrack.addEventListener('mouseup', () => {
      isDown = false;
      restartAutoSlideDelayed(2500);
    });

    testiTrack.addEventListener('mousemove', (e) => {
      if (!isDown) return;
      e.preventDefault();
      const x = e.pageX - testiTrack.offsetLeft;
      const walk = (x - startX) * 1.5;
      testiTrack.scrollLeft = scrollStart - walk;
    });
  }

  // Khởi tạo tương tác Menu Section (Chạm để bật/tắt trên Mobile/Tablet)
  const menuRows = document.querySelectorAll('.menu-item-row');
  if (menuRows.length > 0) {
    menuRows.forEach((row) => {
      row.addEventListener('click', () => {
        const isAlreadyActive = row.classList.contains('is-active');
        menuRows.forEach((r) => r.classList.remove('is-active'));
        if (!isAlreadyActive) {
          row.classList.add('is-active');
        }
      });
    });
  }
}

// Chạy an toàn bất kể thời điểm script được tải (chạy ngay nếu sẵn sàng hoặc đợi DOMContentLoaded)
function initHome() {
  initWanderLoader();
  initHomePageFeatures();
}

if (document.readyState !== "loading") {
  initHome();
} else {
  document.addEventListener("DOMContentLoaded", initHome);
}