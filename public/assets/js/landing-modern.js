// Landing Page Modern 2025 - JavaScript

document.addEventListener("DOMContentLoaded", function () {
  // Navigation
  const navLinks = document.querySelectorAll(".nav-link");
  const hamburger = document.querySelector(".hamburger");
  const navMenu = document.querySelector(".nav-menu");

  // Smooth scroll and active link
  navLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
      const href = this.getAttribute("href");

      if (href.startsWith("#")) {
        e.preventDefault();

        // Remove active class from all links
        navLinks.forEach((l) => l.classList.remove("active"));

        // Add active class to clicked link
        this.classList.add("active");

        // Scroll to section
        const section = document.querySelector(href);
        if (section) {
          section.scrollIntoView({ behavior: "smooth" });
        }
      }
    });
  });

  // Update active link on scroll
  window.addEventListener("scroll", function () {
    let current = "";
    const sections = document.querySelectorAll("section[id]");

    sections.forEach((section) => {
      const sectionTop = section.offsetTop;
      const sectionHeight = section.clientHeight;

      if (pageYOffset >= sectionTop - 200) {
        current = section.getAttribute("id");
      }
    });

    navLinks.forEach((link) => {
      link.classList.remove("active");
      if (link.getAttribute("href") === "#" + current) {
        link.classList.add("active");
      }
    });
  });

  // Hamburger menu toggle
  if (hamburger) {
    hamburger.addEventListener("click", function () {
      navMenu.style.display =
        navMenu.style.display === "flex" ? "none" : "flex";
    });
  }

  // Scroll animations
  const observerOptions = {
    threshold: 0.1,
    rootMargin: "0px 0px -100px 0px",
  };

  const observer = new IntersectionObserver(function (entries) {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = "1";
        entry.target.style.transform = "translateY(0)";
      }
    });
  }, observerOptions);

  // Observe all cards and sections
  document
    .querySelectorAll(".feature-card, .package-card, .testimonial-card")
    .forEach((el) => {
      el.style.opacity = "0";
      el.style.transform = "translateY(20px)";
      el.style.transition = "all 0.6s ease-out";
      observer.observe(el);
    });

  // Counter animation
  const animateCounters = () => {
    const stats = document.querySelectorAll(".stat h4");

    stats.forEach((stat) => {
      const target = parseInt(stat.textContent);
      const increment = target / 50;
      let current = 0;

      const updateCount = () => {
        current += increment;
        if (current < target) {
          stat.textContent = Math.ceil(current) + "+";
          requestAnimationFrame(updateCount);
        } else {
          stat.textContent = target + "+";
        }
      };

      updateCount();
    });
  };

  // Trigger counter animation when stats section is visible
  const statsSection = document.querySelector(".about-stats");
  if (statsSection) {
    const statsObserver = new IntersectionObserver(
      function (entries) {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            animateCounters();
            statsObserver.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.5 }
    );

    statsObserver.observe(statsSection);
  }

  // Parallax effect on scroll
  window.addEventListener("scroll", function () {
    const scrolled = window.pageYOffset;
    const blobs = document.querySelectorAll(".gradient-blob");

    blobs.forEach((blob, index) => {
      const speed = 0.5 + index * 0.1;
      blob.style.transform = `translateY(${scrolled * speed}px)`;
    });
  });

  // Button ripple effect
  const buttons = document.querySelectorAll(".btn");
  buttons.forEach((button) => {
    button.addEventListener("click", function (e) {
      const ripple = document.createElement("span");
      const rect = this.getBoundingClientRect();
      const size = Math.max(rect.width, rect.height);
      const x = e.clientX - rect.left - size / 2;
      const y = e.clientY - rect.top - size / 2;

      ripple.style.width = ripple.style.height = size + "px";
      ripple.style.left = x + "px";
      ripple.style.top = y + "px";
      ripple.classList.add("ripple");

      this.appendChild(ripple);

      setTimeout(() => ripple.remove(), 600);
    });
  });

  // Smooth navbar background on scroll
  window.addEventListener("scroll", function () {
    const navbar = document.querySelector(".navbar");
    if (window.scrollY > 50) {
      navbar.style.background = "rgba(255, 255, 255, 0.95)";
    } else {
      navbar.style.background = "rgba(255, 255, 255, 0.7)";
    }
  });

  // Mobile menu close on link click
  navLinks.forEach((link) => {
    link.addEventListener("click", function () {
      if (navMenu) {
        navMenu.style.display = "none";
      }
    });
  });

  // Lazy load images
  if ("IntersectionObserver" in window) {
    const imageObserver = new IntersectionObserver((entries, observer) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const img = entry.target;
          img.src = img.dataset.src || img.src;
          img.classList.add("loaded");
          observer.unobserve(img);
        }
      });
    });

    document
      .querySelectorAll("img")
      .forEach((img) => imageObserver.observe(img));
  }

  // Add scroll to top button
  const scrollTopBtn = document.createElement("button");
  scrollTopBtn.innerHTML = '<i class="fas fa-arrow-up"></i>';
  scrollTopBtn.className = "scroll-top-btn";
  scrollTopBtn.style.cssText = `
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #6366f1, #ec4899);
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 999;
        box-shadow: 0 10px 25px rgba(99, 102, 241, 0.3);
        transition: all 0.3s ease;
    `;

  document.body.appendChild(scrollTopBtn);

  window.addEventListener("scroll", function () {
    if (window.pageYOffset > 300) {
      scrollTopBtn.style.display = "flex";
    } else {
      scrollTopBtn.style.display = "none";
    }
  });

  scrollTopBtn.addEventListener("click", function () {
    window.scrollTo({ top: 0, behavior: "smooth" });
  });

  scrollTopBtn.addEventListener("mouseenter", function () {
    this.style.transform = "scale(1.1)";
  });

  scrollTopBtn.addEventListener("mouseleave", function () {
    this.style.transform = "scale(1)";
  });
});

// Add ripple effect CSS
const style = document.createElement("style");
style.textContent = `
    .btn {
        position: relative;
        overflow: hidden;
    }

    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.6);
        transform: scale(0);
        animation: ripple-animation 0.6s ease-out;
        pointer-events: none;
    }

    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
