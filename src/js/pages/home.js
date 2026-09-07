// JS dành riêng cho trang chủ (Home Page) - Wander Loading Reveal
function initWanderLoader() {
  console.log("Wander Home Page Script Loaded!");

  const stackWrap = document.getElementById('stackWrap');
  const pctNum  = document.getElementById('pctNum');
  const progressBar = document.getElementById('progressBar');
  const loader  = document.getElementById('loader');
  const board   = document.getElementById('board');
  const wash    = document.getElementById('wash');
  const home    = document.getElementById('home-wander');

  // Đọc danh sách ảnh truyền từ WordPress qua biến toàn cục (lấy tối đa 10 ảnh)
  const rawImages = window.WanderConfig?.images || [];
  const IMAGES = Array.isArray(rawImages) && rawImages.length > 0 ? rawImages.slice(0, 10) : [];

  if (IMAGES.length === 0) {
    console.warn("Wander Loader: No images configured.");
    document.body.classList.add('is-loaded');
    if (home) home.classList.add('reveal');
    if (loader) loader.remove();
  }

  // Bố cục moodboard trên Desktop & Màn hình lớn
  const DESKTOP_LAYOUT = [
    { left: 3,  top: 6,  w: 170, h: 220, rot: -5 },
    { left: 20, top: 3,  w: 160, h: 210, rot: -7 },
    { left: 44, top: 1,  w: 165, h: 195, rot: 3  },
    { left: 65, top: 9,  w: 195, h: 175, rot: -2 },
    { left: 86, top: 4,  w: 150, h: 215, rot: 6  },
    { left: 12, top: 54, w: 150, h: 195, rot: -4 },
    { left: 33, top: 60, w: 195, h: 175, rot: 3  },
    { left: 56, top: 57, w: 195, h: 175, rot: -3 },
    { left: 79, top: 52, w: 150, h: 215, rot: 5  },
    { left: -4, top: 80, w: 165, h: 205, rot: -8 }
  ];

  // Bố cục moodboard tối ưu riêng cho Mobile (xếp viền cân đối, không đè câu nói chính giữa)
  const MOBILE_LAYOUT = [
    { left: -2, top: 3,  w: 92,  h: 124, rot: -6 },
    { left: 68, top: 4,  w: 98,  h: 130, rot: 6  },
    { left: 33, top: 1,  w: 88,  h: 118, rot: -2 },
    { left: 76, top: 22, w: 94,  h: 126, rot: 5  },
    { left: -7, top: 24, w: 90,  h: 122, rot: -5 },
    { left: -6, top: 66, w: 96,  h: 128, rot: 5  },
    { left: 74, top: 68, w: 92,  h: 124, rot: -5 },
    { left: 2,  top: 82, w: 98,  h: 132, rot: -4 },
    { left: 36, top: 84, w: 92,  h: 124, rot: 4  },
    { left: 70, top: 81, w: 88,  h: 120, rot: 3  }
  ];

  const vw = () => window.innerWidth;
  const vh = () => window.innerHeight;
  const isMobile = () => window.innerWidth < 768;

  const px = (layout) => ({
    x: layout.left / 100 * vw(),
    y: layout.top  / 100 * vh(),
    w: layout.w, h: layout.h, rot: layout.rot
  });

  // ---------- Bước 1: Đếm 1/10 -> 10/10 với hoạt ảnh xấp bài mượt mà ----------
  let i = 0;
  const STACK_OFFSET = [
    { x:-7,  y: 5,  rot:-9  },
    { x: 6,  y:-4,  rot: 7  },
    { x:-4,  y:-7,  rot:-5  },
    { x: 8,  y: 6,  rot: 11 },
    { x:-9,  y: 2,  rot:-12 },
    { x: 4,  y:-8,  rot: 6  },
    { x:-3,  y: 8,  rot:-7  },
    { x: 9,  y:-5,  rot: 10 },
    { x:-8,  y:-3,  rot:-10 },
    { x: 3,  y: 7,  rot: 5  }
  ];

  const stackCards = [];
  const totalSteps = Math.min(10, IMAGES.length);
  const stepTime = 160; // 160ms mỗi nhịp đếm -> tổng cộng ~1.6s

  function loadStep(){
    i++;
    const percent = Math.min(100, Math.round((i / totalSteps) * 100));
    if (pctNum) pctNum.textContent = percent + '%';
    if (progressBar) progressBar.style.width = percent + '%';

    const off = STACK_OFFSET[(i - 1) % STACK_OFFSET.length];
    const card = document.createElement('div');
    card.className = 'photo';
    card.style.backgroundImage = `url('${IMAGES[i-1]}')`;
    card.style.zIndex = i;
    if (stackWrap) stackWrap.appendChild(card);
    stackCards.push(card);

    // Hoạt ảnh quăng bài bay vào (Tinh chỉnh nhẹ trên Mobile không bị giật hay tràn viền)
    const mobile = isMobile();
    const fromSide = (i % 2 === 0) ? 1 : -1;
    const fromX = fromSide * (mobile ? 65 : 130);
    const fromY = (mobile ? -20 : -40) + Math.random() * 18;
    const fromRot = fromSide * (mobile ? 32 : 55);
    const scaleOff = mobile ? 0.7 : 1;
    const targetX = off.x * scaleOff;
    const targetY = off.y * scaleOff;

    if (card.animate) {
      card.animate([
        { transform:`translate(${fromX}px, ${fromY}px) rotate(${fromRot}deg) scale(0.7)`, opacity: 0 },
        { transform:`translate(${targetX * 0.6}px, ${targetY * 0.6}px) rotate(${off.rot * 1.3}deg) scale(1.05)`, opacity: 1, offset: 0.65 },
        { transform:`translate(${targetX}px, ${targetY}px) rotate(${off.rot}deg) scale(1)`, opacity: 1 }
      ], {
        duration: stepTime + 100,
        easing: 'cubic-bezier(.25,.85,.35,1.1)',
        fill: 'forwards'
      });
    } else {
      card.style.opacity = '1';
    }

    if (i < totalSteps){
      setTimeout(loadStep, stepTime);
    } else {
      setTimeout(bloom, 220); // Dừng lại một nhịp ngắn rồi tỏa ảnh
    }
  }

  // Khởi chạy
  if (loader && IMAGES.length > 0) {
    setTimeout(loadStep, 150);
  } else {
    document.body.classList.add('is-loaded');
    if (home) home.classList.add('reveal');
    if (loader) loader.remove();
  }

  // ---------- Bước 2: Ảnh bay tỏa ra (bloom) về vị trí moodboard ----------
  function bloom(){
    const mobile = isMobile();
    const activeLayout = mobile ? MOBILE_LAYOUT : DESKTOP_LAYOUT;
    const frameW = mobile ? 125 : 170;
    const frameH = mobile ? 160 : 210;
    const originX = vw() / 2 - frameW / 2;
    const originY = vh() / 2 - frameH / 2;

    IMAGES.forEach((src, idx) => {
      const target = px(activeLayout[idx % activeLayout.length]);
      const tile = document.createElement('div');
      tile.className = 'tile';
      tile.style.backgroundImage = `url('${src}')`;
      tile.style.width  = target.w + 'px';
      tile.style.height = target.h + 'px';
      tile.style.left = originX + 'px';
      tile.style.top  = originY + 'px';
      if (board) board.appendChild(tile);

      const dx = target.x - originX;
      const dy = target.y - originY;

      // Độ cong đường bay (êm ái và không bay vọt ra khỏi màn hình điện thoại)
      const arcSide = (idx % 2 === 0 ? 1 : -1);
      const arcBend = (mobile ? 45 : 90) + Math.random() * (mobile ? 35 : 70);
      const midX = dx * 0.5 + arcSide * arcBend * (dy >= 0 ? 0.4 : -0.4);
      const midY = dy * 0.5 - ((mobile ? 65 : 120) + Math.random() * (mobile ? 30 : 60));

      const flipRot = target.rot + arcSide * (mobile ? 75 : 140) + Math.random() * (mobile ? 50 : 100);
      const delay = (mobile ? 50 : 80) + idx * (mobile ? 45 : 60);

      if (tile.animate) {
        tile.animate([
          { transform:`translate(0px,0px) rotate(0deg) scale(0.4)`,               opacity: 0,  offset: 0 },
          { transform:`translate(${midX*0.35}px,${midY*0.35}px) rotate(${flipRot*0.3}deg) scale(0.75)`, opacity: 1, offset: 0.18 },
          { transform:`translate(${midX}px,${midY}px) rotate(${flipRot}deg) scale(1.1)`,   opacity: 1, offset: 0.55 },
          { transform:`translate(${dx*0.94}px,${dy*0.94}px) rotate(${target.rot*0.9}deg) scale(1.03)`, opacity: 1, offset: 0.86 },
          { transform:`translate(${dx}px,${dy}px) rotate(${target.rot}deg) scale(1)`,       opacity: 1, offset: 1 }
        ], {
          duration: mobile ? 1000 : 1200,
          delay: delay,
          easing: 'cubic-bezier(.22,.7,.2,1)',
          fill: 'forwards'
        });
      } else {
        tile.style.transform = `translate(${dx}px, ${dy}px) rotate(${target.rot}deg)`;
        tile.style.opacity = '1';
      }
    });

    // Ẩn khung loader ngay khi ảnh bắt đầu bung ra
    if (loader) {
      loader.style.transition = 'opacity 500ms ease';
      loader.style.opacity = '0';
      setTimeout(() => {
        if (loader && loader.parentNode) loader.remove();
      }, 550);
    }

    // Lớp phủ ấm hiện dần
    setTimeout(() => {
      if (wash) {
        wash.style.transition = 'opacity 800ms ease';
        wash.style.opacity = '1';
      }
    }, 350);

    // Chữ nội dung trồi lên thanh lịch và mở khóa thanh cuộn trang
    setTimeout(() => {
      if (home) {
        home.classList.add('reveal');
      }
      document.body.classList.add('is-loaded');
    }, 600);
  }

  // Failsafe: Đảm bảo sau tối đa 3.2 giây chữ LUÔN LUÔN HIỂN THỊ trong mọi tình huống
  setTimeout(() => {
    if (home && !home.classList.contains('reveal')) {
      home.classList.add('reveal');
    }
    document.body.classList.add('is-loaded');
    if (wash) wash.style.opacity = '1';
    if (loader && loader.parentNode) {
      loader.style.opacity = '0';
      setTimeout(() => {
        if (loader && loader.parentNode) loader.remove();
      }, 400);
    }
  }, 3200);

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

    // 3. Hiệu ứng Fixed Parallax nhẹ nhàng cho các hình ảnh trong trang
    if (parallaxMedia.length > 0) {
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

  // Khởi tạo bộ điều khiển Testimonials Slider
  const testiTrack   = document.getElementById('testimonials-track');
  const testiPrevBtn = document.getElementById('testi-prev-btn');
  const testiNextBtn = document.getElementById('testi-next-btn');

  if (testiTrack) {
    const getScrollAmount = () => {
      const firstSlide = testiTrack.querySelector('.testi-slide');
      return firstSlide ? firstSlide.offsetWidth : 320;
    };

    if (testiNextBtn) {
      testiNextBtn.addEventListener('click', () => {
        testiTrack.scrollBy({ left: getScrollAmount(), behavior: 'smooth' });
      });
    }

    if (testiPrevBtn) {
      testiPrevBtn.addEventListener('click', () => {
        testiTrack.scrollBy({ left: -getScrollAmount(), behavior: 'smooth' });
      });
    }

    // Hỗ trợ kéo lướt bằng chuột (Mouse Drag)
    let isDown = false;
    let startX = 0;
    let scrollStart = 0;

    testiTrack.addEventListener('mousedown', (e) => {
      isDown = true;
      startX = e.pageX - testiTrack.offsetLeft;
      scrollStart = testiTrack.scrollLeft;
    });

    testiTrack.addEventListener('mouseleave', () => { isDown = false; });
    testiTrack.addEventListener('mouseup', () => { isDown = false; });

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
if (document.readyState !== "loading") {
  initWanderLoader();
} else {
  document.addEventListener("DOMContentLoaded", initWanderLoader);
}