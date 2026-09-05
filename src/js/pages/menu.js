// Interactive Menu Page JavaScript (On The Rock Cocktail Bar)
// Hỗ trợ cả 3 Layouts, triệt để chống bị Header che khuất khi cuộn hay click menu.

function initMenuPage() {
  const getHeaderOffset = () => {
    const header = document.getElementById('site-header');
    return header ? header.offsetHeight + 20 : 110;
  };

  // ================= 1. KIỂU 1: SHOWCASE CARD & SLIDER (ACCORDION) ================= //
  const categoryRows = document.querySelectorAll('.menu-category-row');
  const categoryPanels = document.querySelectorAll('.menu-category-panel');

  if (categoryRows.length > 0) {
    categoryRows.forEach((row) => {
      row.addEventListener('click', () => {
        const catId = row.getAttribute('data-category-id');
        const targetPanel = document.querySelector(`.menu-category-panel[data-category-id="${catId}"]`);
        const isCurrentlyOpen = row.classList.contains('is-open');

        // Đóng các panel khác nếu muốn dạng single-accordion
        categoryRows.forEach((r) => {
          if (r !== row) {
            r.classList.remove('is-open');
            const icon = r.querySelector('.menu-row-arrow');
            if (icon) icon.classList.remove('rotate-180');
          }
        });
        categoryPanels.forEach((p) => {
          if (p !== targetPanel) {
            p.classList.add('hidden');
          }
        });

        // Bật/tắt panel hiện tại
        if (isCurrentlyOpen) {
          row.classList.remove('is-open');
          const icon = row.querySelector('.menu-row-arrow');
          if (icon) icon.classList.remove('rotate-180');
          if (targetPanel) {
            targetPanel.classList.add('hidden');
          }
        } else {
          row.classList.add('is-open');
          const icon = row.querySelector('.menu-row-arrow');
          if (icon) icon.classList.add('rotate-180');
          if (targetPanel) {
            targetPanel.classList.remove('hidden');
            targetPanel.classList.add('animate-fadeIn');

            // Cuộn êm đến hàng đang mở, bù trừ chiều cao Fixed Header để không bị che
            setTimeout(() => {
              const offset = getHeaderOffset();
              const rowTop = row.getBoundingClientRect().top + window.pageYOffset - offset;
              window.scrollTo({
                top: Math.max(0, rowTop),
                behavior: 'smooth'
              });
            }, 100);
          }
        }
      });
    });
  }

  // 1.1 Tab chuyển đổi Sub-category Layout 1 (Classic / Deluxe / Premium)
  const subTabs = document.querySelectorAll('.menu-subtab-btn');
  if (subTabs.length > 0) {
    subTabs.forEach((tab) => {
      tab.addEventListener('click', () => {
        const parentPanel = tab.closest('.menu-category-panel');
        if (!parentPanel) return;

        const tabKey = tab.getAttribute('data-subtab');

        // Cập nhật trạng thái nút tab
        parentPanel.querySelectorAll('.menu-subtab-btn').forEach((t) => {
          t.classList.remove('bg-[#c8a773]', 'text-[#1a120b]', 'font-semibold');
          t.classList.add('bg-transparent', 'text-[#caa875]', 'border-dashed');
        });
        tab.classList.remove('bg-transparent', 'text-[#caa875]', 'border-dashed');
        tab.classList.add('bg-[#c8a773]', 'text-[#1a120b]', 'font-semibold');

        // Ẩn/Hiện nội dung view tương ứng
        parentPanel.querySelectorAll('.subtab-content-view').forEach((view) => {
          if (view.getAttribute('data-subtab-view') === tabKey) {
            view.classList.remove('hidden');
            view.classList.add('animate-fadeIn');
          } else {
            view.classList.add('hidden');
            view.classList.remove('animate-fadeIn');
          }
        });
      });
    });
  }

  // 1.2 Slider hình ảnh Cocktail Layout 1
  const sliderContainers = document.querySelectorAll('.cocktail-slider-wrap');
  if (sliderContainers.length > 0) {
    sliderContainers.forEach((slider) => {
      const slides = slider.querySelectorAll('.cocktail-slide');
      const prevBtn = slider.querySelector('.slider-btn-prev');
      const nextBtn = slider.querySelector('.slider-btn-next');
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
      };

      if (nextBtn) {
        nextBtn.addEventListener('click', (e) => {
          e.stopPropagation();
          currentIndex = (currentIndex + 1) % slides.length;
          updateSlides();
        });
      }

      if (prevBtn) {
        prevBtn.addEventListener('click', (e) => {
          e.stopPropagation();
          currentIndex = (currentIndex - 1 + slides.length) % slides.length;
          updateSlides();
        });
      }

      updateSlides();
    });
  }

  // 1.3 Tương tác chọn nốt vị (Flavor Tag Selection)
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

  // 1.4 Tương tác chọn mức độ cồn (Alcohol Level Pill)
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

  // ================= 2. KIỂU 2: STICKY SIDEBAR SCROLLSPY & SMOOTH SCROLL ================= //
  const sidebarLinks = document.querySelectorAll('.sidebar-nav-item');
  const sidebarSections = document.querySelectorAll('.sidebar-content-section');

  if (sidebarLinks.length > 0 && sidebarSections.length > 0) {
    // Click vào sidebar item: Cuộn mượt với bù trừ Fixed Header
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

          // Cập nhật trạng thái active ngay lập tức
          sidebarLinks.forEach((l) => {
            l.classList.remove('bg-[#caa875]/20', 'text-white', 'font-semibold');
            l.classList.add('text-[#caa875]/75');
          });
          link.classList.add('bg-[#caa875]/20', 'text-white', 'font-semibold');
          link.classList.remove('text-[#caa875]/75');
        }
      });
    });

    // ScrollSpy: Tự động đánh dấu mục trên sidebar khi cuộn trang
    let scrollTimeout = null;
    const handleScrollSpy = () => {
      const scrollPos = window.pageYOffset + getHeaderOffset() + 40;
      sidebarSections.forEach((section) => {
        const top = section.offsetTop;
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
        }, 80);
      }
    }, { passive: true });
  }

  // ================= 3. KIỂU 3: DANH SÁCH CỘT THEO NỀN RƯỢU (CLASSIC COLUMNS TABS) ================= //
  const layout3TabBtns = document.querySelectorAll('.menu-layout3-tab-btn');
  if (layout3TabBtns.length > 0) {
    layout3TabBtns.forEach((btn) => {
      btn.addEventListener('click', () => {
        const catGroup = btn.getAttribute('data-target-group');
        const subtabTarget = btn.getAttribute('data-target-subtab');
        const catBlock = btn.closest('.menu-cat-block');

        if (!catBlock) return;

        // Cập nhật giao diện nút Tab trong block
        catBlock.querySelectorAll('.menu-layout3-tab-btn').forEach((b) => {
          b.classList.remove('bg-[#c8a773]', 'text-[#1a120b]', 'font-semibold', 'border-[#c8a773]', 'shadow-lg');
          b.classList.add('bg-[#211508]/80', 'text-[#caa875]', 'border-dashed', 'border-[#caa875]/30');
        });
        btn.classList.remove('bg-[#211508]/80', 'text-[#caa875]', 'border-dashed', 'border-[#caa875]/30');
        btn.classList.add('bg-[#c8a773]', 'text-[#1a120b]', 'font-semibold', 'border-[#c8a773]', 'shadow-lg');

        // Chuyển đổi hiển thị bảng 2 cột
        catBlock.querySelectorAll('.layout3-subtab-view').forEach((view) => {
          if (view.getAttribute('data-subtab-view') === subtabTarget) {
            view.classList.remove('hidden');
            view.classList.add('animate-fadeIn');
          } else {
            view.classList.add('hidden');
            view.classList.remove('animate-fadeIn');
          }
        });
      });
    });
  }
}

if (document.readyState !== "loading") {
  initMenuPage();
} else {
  document.addEventListener("DOMContentLoaded", initMenuPage);
}
