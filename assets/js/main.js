/**
 * DecorZa Theme - Main JavaScript
 * Lightweight, zero-dependency Vanilla JavaScript for UI interactions
 *
 * @package DecorZa
 * @version 1.0.0
 */

(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {
    initStickyHeader();
    initMobileDrawer();
    initSearchModal();
    initDarkMode();
    initBackToTop();
    initReadingProgress();
    initTableOfContents();
    initSocialShare();
    initContactForm();
  });

  /**
   * 1. Sticky Header on Scroll
   */
  function initStickyHeader() {
    var header = document.querySelector('.decorza-site-header');
    if (!header || !header.classList.contains('enable-sticky')) return;

    var scrollThreshold = 80;
    var lastScroll = 0;

    window.addEventListener('scroll', function () {
      var currentScroll = window.pageYOffset || document.documentElement.scrollTop;

      if (currentScroll > scrollThreshold) {
        if (!header.classList.contains('is-sticky')) {
          header.classList.add('is-sticky');
        }
      } else {
        if (header.classList.contains('is-sticky')) {
          header.classList.remove('is-sticky');
        }
      }
      lastScroll = currentScroll;
    }, { passive: true });
  }

  /**
   * 2. Mobile Drawer Navigation
   */
  function initMobileDrawer() {
    var toggleBtn = document.querySelector('.decorza-mobile-toggle');
    var drawer = document.querySelector('.decorza-mobile-drawer');
    var overlay = document.querySelector('.decorza-drawer-overlay');
    var closeBtn = document.querySelector('.decorza-drawer-close');

    if (!toggleBtn || !drawer || !overlay) return;

    function openDrawer() {
      drawer.classList.add('is-open');
      overlay.classList.add('is-active');
      toggleBtn.setAttribute('aria-expanded', 'true');
      drawer.setAttribute('aria-hidden', 'false');
      document.body.style.overflow = 'hidden';
    }

    function closeDrawer() {
      drawer.classList.remove('is-open');
      overlay.classList.remove('is-active');
      toggleBtn.setAttribute('aria-expanded', 'false');
      drawer.setAttribute('aria-hidden', 'true');
      document.body.style.overflow = '';
    }

    toggleBtn.addEventListener('click', function (e) {
      e.preventDefault();
      var isOpen = drawer.classList.contains('is-open');
      if (isOpen) {
        closeDrawer();
      } else {
        openDrawer();
      }
    });

    if (closeBtn) {
      closeBtn.addEventListener('click', function (e) {
        e.preventDefault();
        closeDrawer();
      });
    }

    overlay.addEventListener('click', closeDrawer);

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && drawer.classList.contains('is-open')) {
        closeDrawer();
      }
    });
  }

  /**
   * 3. Expandable Search Modal
   */
  function initSearchModal() {
    var searchToggles = document.querySelectorAll('.decorza-search-toggle');
    var searchModal = document.querySelector('.decorza-search-modal');
    var searchClose = document.querySelector('.decorza-search-close');
    var searchInput = document.querySelector('.decorza-search-input');

    if (!searchModal) return;

    function openSearch() {
      searchModal.classList.add('is-active');
      searchModal.setAttribute('aria-hidden', 'false');
      if (searchInput) {
        setTimeout(function () {
          searchInput.focus();
        }, 150);
      }
    }

    function closeSearch() {
      searchModal.classList.remove('is-active');
      searchModal.setAttribute('aria-hidden', 'true');
    }

    searchToggles.forEach(function (btn) {
      btn.addEventListener('click', function (e) {
        e.preventDefault();
        openSearch();
      });
    });

    if (searchClose) {
      searchClose.addEventListener('click', function (e) {
        e.preventDefault();
        closeSearch();
      });
    }

    searchModal.addEventListener('click', function (e) {
      if (e.target === searchModal) {
        closeSearch();
      }
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && searchModal.classList.contains('is-active')) {
        closeSearch();
      }
    });
  }

  /**
   * 4. Dark / Light Mode Toggle
   */
  function initDarkMode() {
    var toggleButtons = document.querySelectorAll('.decorza-dark-mode-toggle');
    var root = document.documentElement;
    var storageKey = 'decorza_theme_mode';

    // Check localStorage or system preference
    var savedTheme = localStorage.getItem(storageKey);
    var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;

    if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
      root.setAttribute('data-theme', 'dark');
      updateIcons('dark');
    } else {
      root.setAttribute('data-theme', 'light');
      updateIcons('light');
    }

    function updateIcons(mode) {
      toggleButtons.forEach(function (btn) {
        var sunIcon = btn.querySelector('.icon-sun');
        var moonIcon = btn.querySelector('.icon-moon');
        if (sunIcon && moonIcon) {
          if (mode === 'dark') {
            sunIcon.style.display = 'block';
            moonIcon.style.display = 'none';
          } else {
            sunIcon.style.display = 'none';
            moonIcon.style.display = 'block';
          }
        }
      });
    }

    toggleButtons.forEach(function (btn) {
      btn.addEventListener('click', function (e) {
        e.preventDefault();
        var currentTheme = root.getAttribute('data-theme');
        var newTheme = currentTheme === 'dark' ? 'light' : 'dark';

        root.setAttribute('data-theme', newTheme);
        localStorage.setItem(storageKey, newTheme);
        updateIcons(newTheme);
      });
    });
  }

  /**
   * 5. Back to Top Button
   */
  function initBackToTop() {
    var backToTopBtn = document.querySelector('.decorza-back-to-top');
    if (!backToTopBtn) return;

    window.addEventListener('scroll', function () {
      var scrollY = window.pageYOffset || document.documentElement.scrollTop;
      if (scrollY > 350) {
        backToTopBtn.classList.add('is-visible');
      } else {
        backToTopBtn.classList.remove('is-visible');
      }
    }, { passive: true });

    backToTopBtn.addEventListener('click', function (e) {
      e.preventDefault();
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
  }

  /**
   * 6. Reading Progress Bar (Single Post)
   */
  function initReadingProgress() {
    var progressBar = document.querySelector('.decorza-reading-progress');
    var article = document.querySelector('.decorza-article-content');

    if (!progressBar || !article) return;

    window.addEventListener('scroll', function () {
      var articleRect = article.getBoundingClientRect();
      var articleTop = articleRect.top + window.pageYOffset;
      var articleHeight = article.offsetHeight;
      var windowHeight = window.innerHeight;
      var scrollY = window.pageYOffset;

      if (scrollY < articleTop) {
        progressBar.style.width = '0%';
      } else if (scrollY > articleTop + articleHeight - windowHeight) {
        progressBar.style.width = '100%';
      } else {
        var progress = ((scrollY - articleTop) / (articleHeight - windowHeight)) * 100;
        progressBar.style.width = Math.min(100, Math.max(0, progress)) + '%';
      }
    }, { passive: true });
  }

  /**
   * 7. Table of Contents Toggle & Smooth Scroll
   */
  function initTableOfContents() {
    var tocHeader = document.querySelector('.decorza-toc-header');
    var tocList = document.querySelector('.decorza-toc-list');
    var toggleText = document.querySelector('.decorza-toc-toggle');

    if (tocHeader && tocList) {
      tocHeader.addEventListener('click', function () {
        var isHidden = tocList.style.display === 'none';
        tocList.style.display = isHidden ? 'block' : 'none';
        if (toggleText) {
          toggleText.textContent = isHidden ? '[Hide]' : '[Show]';
        }
      });
    }

    // Smooth scroll for TOC links
    var tocLinks = document.querySelectorAll('.decorza-toc-list a');
    tocLinks.forEach(function (link) {
      link.addEventListener('click', function (e) {
        var targetId = this.getAttribute('href');
        if (targetId && targetId.startsWith('#')) {
          var targetElem = document.querySelector(targetId);
          if (targetElem) {
            e.preventDefault();
            var headerOffset = 90;
            var elementPosition = targetElem.getBoundingClientRect().top;
            var offsetPosition = elementPosition + window.pageYOffset - headerOffset;

            window.scrollTo({
              top: offsetPosition,
              behavior: 'smooth'
            });
          }
        }
      });
    });
  }

  /**
   * 8. Social Share (Copy Link)
   */
  function initSocialShare() {
    var copyButtons = document.querySelectorAll('.decorza-share-copy');
    copyButtons.forEach(function (btn) {
      btn.addEventListener('click', function (e) {
        e.preventDefault();
        var url = window.location.href;

        if (navigator.clipboard && navigator.clipboard.writeText) {
          navigator.clipboard.writeText(url).then(function () {
            showToast('Link copied to clipboard!');
          });
        } else {
          // Fallback
          var tempInput = document.createElement('input');
          tempInput.value = url;
          document.body.appendChild(tempInput);
          tempInput.select();
          document.execCommand('copy');
          document.body.removeChild(tempInput);
          showToast('Link copied to clipboard!');
        }
      });
    });

    function showToast(message) {
      var existing = document.querySelector('.decorza-toast');
      if (existing) existing.remove();

      var toast = document.createElement('div');
      toast.className = 'decorza-toast';
      toast.textContent = message;
      toast.style.position = 'fixed';
      toast.style.bottom = '80px';
      toast.style.left = '50%';
      toast.style.transform = 'translateX(-50%)';
      toast.style.backgroundColor = '#2C3E50';
      toast.style.color = '#FFFFFF';
      toast.style.padding = '10px 20px';
      toast.style.borderRadius = '30px';
      toast.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
      toast.style.zIndex = '99999';
      toast.style.fontSize = '14px';
      toast.style.fontWeight = '500';

      document.body.appendChild(toast);
      setTimeout(function () {
        toast.style.transition = 'opacity 0.4s ease';
        toast.style.opacity = '0';
        setTimeout(function () {
          toast.remove();
        }, 400);
      }, 2500);
    }
  }

  /**
   * 9. AJAX Contact Form Submission
   */
  function initContactForm() {
    var form = document.getElementById('decorza-contact-form');
    if (!form) return;

    var alertBox = form.parentElement.querySelector('.decorza-ajax-alert');
    var submitBtn = form.querySelector('.decorza-contact-submit-btn');
    var originalBtnHtml = submitBtn ? submitBtn.innerHTML : '';

    form.addEventListener('submit', function (e) {
      if (typeof decorza_ajax_obj === 'undefined') {
        // Fall back to native POST submission
        return;
      }

      e.preventDefault();

      // Check honeypot
      var hp = form.querySelector('#decorza_hp');
      if (hp && hp.value) {
        return;
      }

      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span>Sending Message...</span>';
      }

      var formData = new FormData(form);
      formData.append('action', 'decorza_contact');
      formData.append('nonce', decorza_ajax_obj.nonce);

      fetch(decorza_ajax_obj.ajax_url, {
        method: 'POST',
        body: formData
      })
      .then(function (res) {
        return res.json();
      })
      .then(function (data) {
        if (alertBox) {
          alertBox.style.display = 'flex';
          if (data.success) {
            alertBox.className = 'decorza-alert decorza-alert-success';
            alertBox.innerHTML = '<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg><span>' + data.data.message + '</span>';
            form.reset();
          } else {
            alertBox.className = 'decorza-alert decorza-alert-error';
            alertBox.innerHTML = '<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg><span>' + (data.data && data.data.message ? data.data.message : 'Error sending message.') + '</span>';
          }
          alertBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
      })
      .catch(function () {
        if (alertBox) {
          alertBox.style.display = 'flex';
          alertBox.className = 'decorza-alert decorza-alert-error';
          alertBox.innerHTML = '<span>An unexpected network error occurred. Please try again.</span>';
        }
      })
      .finally(function () {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.innerHTML = originalBtnHtml;
        }
      });
    });
  }

})();
