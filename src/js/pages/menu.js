// Interactive Menu Page JavaScript (On The Rock Cocktail Bar)
// Xử lý hiệu ứng hàng Menu Cha mở rộng ("xổ xuống") & chuyển đổi các Menu Con (Tabs).

function initMenuPage() {
  const getHeaderOffset = () => {
    const header = document.getElementById('site-header');
    return header ? header.offsetHeight + 20 : 110;
  };

  // ================= 1. HÀNG MENU CHA XỔ XUỐNG (ACCORDION) ================= //
  const accordionRows = document.querySelectorAll('.menu-accordion-row');
  const accordionPanels = document.querySelectorAll('.menu-accordion-panel');

  if (accordionRows.length > 0) {
    accordionRows.forEach((row) => {
      row.addEventListener('click', () => {
        const chaId = row.getAttribute('data-cha-id');
        const targetPanel = document.querySelector(`.menu-accordion-panel[data-cha-panel="${chaId}"]`);
        const arrow = row.querySelector('.menu-accordion-arrow');
        const isCurrentlyOpen = row.classList.contains('is-open');

        // Đóng các hàng khác
        accordionRows.forEach((r) => {
          if (r !== row) {
            r.classList.remove('is-open');
            const otherArrow = r.querySelector('.menu-accordion-arrow');
            if (otherArrow) otherArrow.classList.remove('rotate-180');
          }
        });
        accordionPanels.forEach((p) => {
          if (p !== targetPanel) {
            p.classList.add('hidden');
            p.classList.remove('animate-fadeIn');
          }
        });

        // Bật/tắt hàng hiện tại
        if (isCurrentlyOpen) {
          row.classList.remove('is-open');
          if (arrow) arrow.classList.remove('rotate-180');
          if (targetPanel) {
            targetPanel.classList.add('hidden');
            targetPanel.classList.remove('animate-fadeIn');
          }
        } else {
          row.classList.add('is-open');
          if (arrow) arrow.classList.add('rotate-180');
          if (targetPanel) {
            targetPanel.classList.remove('hidden');
            targetPanel.classList.add('animate-fadeIn');

            // Làm mới Slider ảnh nếu có trong view vừa mở
            const activeSlider = targetPanel.querySelector('.menu-con-view-panel:not(.hidden) .cocktail-slider-wrap');
            if (activeSlider && typeof activeSlider.refreshSlider === 'function') {
              activeSlider.refreshSlider();
            }

            // Cuộn êm đến hàng đang mở, bù trừ chiều cao Fixed Header
            setTimeout(() => {
              const offset = getHeaderOffset();
              const rowTop = row.getBoundingClientRect().top + window.pageYOffset - offset;
              window.scrollTo({
                top: Math.max(0, rowTop),
                behavior: 'smooth'
              });
            }, 120);
          }
        }
      });
    });
  }

  // ================= 2. CHUYỂN ĐỔI SUBTAB MENU CON (TRONG KHUNG XỔ XUỐNG) ================= //
  const subtabBtns = document.querySelectorAll('.menu-con-subtab-btn');
  if (subtabBtns.length > 0) {
    subtabBtns.forEach((btn) => {
      btn.addEventListener('click', (e) => {
        e.stopPropagation();
        const parentCha = btn.getAttribute('data-parent-cha');
        const conTarget = btn.getAttribute('data-con-target');
        const parentPanel = document.querySelector(`.menu-accordion-panel[data-cha-panel="${parentCha}"]`);

        if (!parentPanel) return;

        // Cập nhật trạng thái nút tab con
        parentPanel.querySelectorAll('.menu-con-subtab-btn').forEach((b) => {
          b.classList.remove('bg-[#c8a773]', 'text-[#1a120b]', 'font-semibold', 'border-[#c8a773]', 'shadow-md');
          b.classList.add('bg-transparent', 'text-[#caa875]', 'border-dashed', 'border-[#caa875]/35');
        });

        btn.classList.remove('bg-transparent', 'text-[#caa875]', 'border-dashed', 'border-[#caa875]/35');
        btn.classList.add('bg-[#c8a773]', 'text-[#1a120b]', 'font-semibold', 'border-[#c8a773]', 'shadow-md');

        // Bật view nội dung tương ứng
        parentPanel.querySelectorAll('.menu-con-view-panel').forEach((view) => {
          if (view.getAttribute('data-con-view') === conTarget) {
            view.classList.remove('hidden');
            view.classList.add('animate-fadeIn');

            const slider = view.querySelector('.cocktail-slider-wrap');
            if (slider && typeof slider.refreshSlider === 'function') {
              slider.refreshSlider();
            }
          } else {
            view.classList.add('hidden');
            view.classList.remove('animate-fadeIn');
          }
        });
      });
    });
  }

  // ================= 3. SLIDER HÌNH ẢNH COCKTAIL (KIỂU 1) ================= //
  const sliderContainers = document.querySelectorAll('.cocktail-slider-wrap');
  if (sliderContainers.length > 0) {
    sliderContainers.forEach((slider) => {
      const slides = slider.querySelectorAll('.cocktail-slide');
      const prevBtn = slider.querySelector('.slider-btn-prev');
      const nextBtn = slider.querySelector('.slider-btn-next');
      const dots = slider.querySelectorAll('.otr-slider-dot');
      let currentIndex = 0;

      const updateSlides = () => {
        slides.forEach((slide, idx) => {
          if (idx === currentIndex) {
            slide.classList.remove('opacity-0', 'pointer-events-none', 'scale-95');
            slide.classList.add('opacity-100', 'scale-100');
          } else {
            slide.classList.add('opacity-0', 'pointer-events-none', 'scale-95');
            slide.classList.remove('opacity-100', 'scale-100');
          }
        });

        if (dots.length > 0) {
          dots.forEach((dot, idx) => {
            if (idx === currentIndex) {
              dot.classList.add('is-active');
            } else {
              dot.classList.remove('is-active');
            }
          });
        }
      };

      slider.refreshSlider = () => {
        updateSlides();
      };

      if (nextBtn) {
        nextBtn.addEventListener('click', (e) => {
          e.stopPropagation();
          e.preventDefault();
          currentIndex = (currentIndex + 1) % slides.length;
          updateSlides();
        });
      }

      if (prevBtn) {
        prevBtn.addEventListener('click', (e) => {
          e.stopPropagation();
          e.preventDefault();
          currentIndex = (currentIndex - 1 + slides.length) % slides.length;
          updateSlides();
        });
      }

      if (dots.length > 0) {
        dots.forEach((dot) => {
          dot.addEventListener('click', (e) => {
            e.stopPropagation();
            e.preventDefault();
            const targetIdx = parseInt(dot.getAttribute('data-slide-index'), 10);
            if (!isNaN(targetIdx) && targetIdx >= 0 && targetIdx < slides.length) {
              currentIndex = targetIdx;
              updateSlides();
            }
          });
        });
      }

      // Hỗ trợ cảm ứng vuốt (Swipe Touch) trên thiết bị di động
      let touchStartX = 0;
      let touchEndX = 0;

      slider.addEventListener('touchstart', (e) => {
        if (e.changedTouches && e.changedTouches.length > 0) {
          touchStartX = e.changedTouches[0].screenX;
        }
      }, { passive: true });

      slider.addEventListener('touchend', (e) => {
        if (e.changedTouches && e.changedTouches.length > 0) {
          touchEndX = e.changedTouches[0].screenX;
          const diffX = touchStartX - touchEndX;
          if (Math.abs(diffX) > 40) {
            if (diffX > 0) {
              currentIndex = (currentIndex + 1) % slides.length;
            } else {
              currentIndex = (currentIndex - 1 + slides.length) % slides.length;
            }
            updateSlides();
          }
        }
      }, { passive: true });

      updateSlides();
    });
  }

  // ================= 4. TƯƠNG TÁC CHỌN NỐT VỊ (FLAVOR TAGS) ================= //
  const flavorPills = document.querySelectorAll('.flavor-tag-pill');
  if (flavorPills.length > 0) {
    flavorPills.forEach((pill) => {
      pill.addEventListener('click', (e) => {
        e.stopPropagation();
        pill.classList.toggle('bg-[#caa875]/25');
        pill.classList.toggle('border-[#caa875]');
      });
    });
  }

  // ================= 5. TƯƠNG TÁC CHỌN NỒNG ĐỘ CỒN ================= //
  const alcoholPills = document.querySelectorAll('.alcohol-level-pill');
  if (alcoholPills.length > 0) {
    alcoholPills.forEach((pill) => {
      pill.addEventListener('click', (e) => {
        e.stopPropagation();
        const group = pill.closest('.alcohol-level-group');
        if (group) {
          group.querySelectorAll('.alcohol-level-pill').forEach((p) => {
            p.classList.remove('bg-[#caa875]', 'text-[#171009]', 'font-bold');
            p.classList.add('bg-transparent', 'text-[#caa875]');
          });
          pill.classList.add('bg-[#caa875]', 'text-[#171009]', 'font-bold');
          pill.classList.remove('bg-transparent', 'text-[#caa875]');
        }
      });
    });
  }

  // ================= 6. KIỂU 2: STICKY SIDEBAR CUỘN TRANG ================= //
  const sidebarLinks = document.querySelectorAll('.sidebar-nav-item');
  const sidebarSections = document.querySelectorAll('.sidebar-content-section');

  if (sidebarLinks.length > 0 && sidebarSections.length > 0) {
    sidebarLinks.forEach((link) => {
      link.addEventListener('click', (e) => {
        e.preventDefault();
        const targetId = link.getAttribute('data-nav-target') || link.getAttribute('href')?.replace('#', '');
        const targetSection = document.getElementById(targetId);

        if (targetSection) {
          const offset = getHeaderOffset();
          const targetTop = targetSection.getBoundingClientRect().top + window.pageYOffset - offset;
          window.scrollTo({
            top: Math.max(0, targetTop),
            behavior: 'smooth'
          });

          sidebarLinks.forEach((l) => {
            l.classList.remove('bg-[#caa875]/20', 'text-white', 'font-semibold');
            l.classList.add('text-[#caa875]/75');
          });
          link.classList.add('bg-[#caa875]/20', 'text-white', 'font-semibold');
          link.classList.remove('text-[#caa875]/75');
        }
      });
    });

    // ScrollSpy tự động đánh dấu mục sidebar khi cuộn chuột qua từng nhóm món
    let scrollTimeout = null;
    const handleScrollSpy = () => {
      const scrollPos = window.pageYOffset + getHeaderOffset() + 60;
      sidebarSections.forEach((section) => {
        const top = section.getBoundingClientRect().top + window.pageYOffset;
        const height = section.offsetHeight;
        const id = section.getAttribute('id');

        if (scrollPos >= top && scrollPos < top + height) {
          sidebarLinks.forEach((link) => {
            const linkTarget = link.getAttribute('data-nav-target') || link.getAttribute('href')?.replace('#', '');
            if (linkTarget === id) {
              link.classList.add('bg-[#caa875]/20', 'text-white', 'font-semibold');
              link.classList.remove('text-[#caa875]/75');
            } else {
              link.classList.remove('bg-[#caa875]/20', 'text-white', 'font-semibold');
              link.classList.add('text-[#caa875]/75');
            }
          });
        }
      });
    };

    window.addEventListener('scroll', () => {
      if (!scrollTimeout) {
        scrollTimeout = setTimeout(() => {
          handleScrollSpy();
          scrollTimeout = null;
        }, 60);
      }
    }, { passive: true });
  }
}

if (document.readyState !== "loading") {
  initMenuPage();
} else {
  document.addEventListener("DOMContentLoaded", initMenuPage);
}
