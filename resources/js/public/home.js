/* ==========================================================================
   DEMINA — Home pública
   Archivo: resources/js/public/home.js
   ========================================================================== */

/* ==========================================================================
   1. Live clock
   ========================================================================== */

function initDeminaClock() {
  const clock = document.querySelector('[data-demina-clock]');

  if (!clock) return;

  const pad = (number) => String(number).padStart(2, '0');

  function tick() {
    const date = new Date();

    clock.textContent = `${pad(date.getHours())}:${pad(date.getMinutes())}:${pad(date.getSeconds())}`;
  }

  tick();
  setInterval(tick, 1000);
}

/* ==========================================================================
   2. Text glitch — letras + sustituciones tipográficas completas
   ========================================================================== */

function initDeminaTextGlitch() {
  const characters = '▓▒░█▄▀■□!@#$%^&*_+-=|<>?/\\01';

  const wordGlitches = {
    DEMINA: [
      'DEMIN@',
      'D3MINA',
      'DEM1NA',
      'DΞMINA',
      'DEMI/NA',
      'D-MINA',
    ],
    LABORATORIO: [
      'LABORATOR10',
      'LAB0RATORIO',
      'L@BORATORIO',
      'LABORAT0RIO',
      'LAB_0RATORIO',
      'LABORATORIØ',
    ],
    'DE ARTES': [
      'DE #RTES',
      'D3 ARTES',
      'DE ART3S',
      'DE_ARTE5',
      'DΞ ARTES',
      'DE /RTES',
    ],
  };

  const elements = document.querySelectorAll('[data-demina-glitch]');

  if (!elements.length) return;

  elements.forEach((element) => {
    const originalText = element.getAttribute('data-text') || element.textContent.trim();

    element.setAttribute('data-original-text', originalText);
    element.setAttribute('data-text', originalText);
    element.textContent = originalText;
  });

  function corruptCharacters(element) {
    const originalText = element.getAttribute('data-original-text');

    if (!originalText) return;

    const letters = [...originalText];
    const changes = Math.ceil(Math.random() * 4);

    for (let i = 0; i < changes; i++) {
      const position = Math.floor(Math.random() * letters.length);
      letters[position] = characters[Math.floor(Math.random() * characters.length)];
    }

    const corrupted = letters.join('');

    element.textContent = corrupted;
    element.setAttribute('data-text', corrupted);

    setTimeout(() => {
      element.textContent = originalText;
      element.setAttribute('data-text', originalText);
    }, 70 + Math.random() * 130);
  }

  function corruptWord(element) {
    const originalText = element.getAttribute('data-original-text');

    if (!originalText) return;

    const variants = wordGlitches[originalText];

    if (!variants || !variants.length) {
      corruptCharacters(element);
      return;
    }

    const variant = variants[Math.floor(Math.random() * variants.length)];

    element.textContent = variant;
    element.setAttribute('data-text', variant);

    setTimeout(() => {
      element.textContent = originalText;
      element.setAttribute('data-text', originalText);
    }, 150 + Math.random() * 260);
  }

  function loop() {
    const element = elements[Math.floor(Math.random() * elements.length)];

    if (Math.random() < 0.45) {
      corruptWord(element);
    } else {
      corruptCharacters(element);
    }

    setTimeout(loop, 180 + Math.random() * 620);
  }

  setTimeout(loop, 900);
}

/* ==========================================================================
   3. Cursor phosphor trail
   ========================================================================== */

function initDeminaCursorTrail() {
  const canvas = document.querySelector('[data-demina-cursor-trail]');

  if (!canvas) return;

  const context = canvas.getContext('2d');

  if (!context) return;

  function resize() {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
  }

  resize();

  window.addEventListener('resize', resize);

  const points = [];
  const maxPoints = 45;
  const lifetime = 850;

  window.addEventListener(
    'mousemove',
    (event) => {
      points.push({
        x: event.clientX,
        y: event.clientY,
        time: Date.now(),
      });

      if (points.length > maxPoints) {
        points.shift();
      }
    },
    { passive: true },
  );

  function draw() {
    context.clearRect(0, 0, canvas.width, canvas.height);

    const now = Date.now();

    for (let i = 1; i < points.length; i++) {
      const point = points[i];
      const age = (now - point.time) / lifetime;

      if (age > 1) continue;

      const alpha = (1 - age) * 0.5;
      const radius = (1 - age) * 3.5 + 0.5;

      context.beginPath();
      context.arc(point.x, point.y, radius, 0, Math.PI * 2);
      context.fillStyle = `rgba(59, 130, 246, ${alpha})`;
      context.fill();
    }

    const cutoff = now - lifetime;

    while (points.length && points[0].time < cutoff) {
      points.shift();
    }

    requestAnimationFrame(draw);
  }

  requestAnimationFrame(draw);
}

/* ==========================================================================
   4. Glitch de imagen por card de espacios — solo hover
   ========================================================================== */

function initDeminaSpaceCardGlitch() {
  const cards = document.querySelectorAll('[data-demina-space-card]');

  if (!cards.length) return;

  cards.forEach((card) => {
    const image = card.querySelector('[data-demina-space-image]');
    const canvas = card.querySelector('[data-demina-space-canvas]');

    if (!image || !canvas) return;

    const context = canvas.getContext('2d');

    if (!context) return;

    const offscreenCanvas = document.createElement('canvas');
    const offscreenContext = offscreenCanvas.getContext('2d');

    if (!offscreenContext) return;

    let width = 0;
    let height = 0;
    let hovering = false;
    let intensity = 0;
    let frame = 0;

    function resize() {
      width = Math.floor(card.offsetWidth);
      height = Math.floor(card.offsetHeight);

      if (!width || !height || width < 1 || height < 1) return;

      canvas.width = offscreenCanvas.width = width;
      canvas.height = offscreenCanvas.height = height;

      drawOffscreen();
    }

    function drawOffscreen() {
      if (!image.complete || image.naturalWidth === 0 || width === 0 || height === 0) return;

      offscreenContext.clearRect(0, 0, width, height);
      offscreenContext.filter = 'brightness(0.9) contrast(1.08) saturate(1.12)';
      offscreenContext.drawImage(image, 0, 0, width, height);
      offscreenContext.filter = 'none';
    }

    function render(currentIntensity) {
      if (!width || !height || width < 1 || height < 1 || offscreenCanvas.width === 0) return;

      context.clearRect(0, 0, width, height);

      if (currentIntensity <= 0) return;

      const bands = Math.floor(2 + currentIntensity * 12);

      for (let i = 0; i < bands; i++) {
        const y = Math.random() * height;
        const bandHeight = Math.random() * (height * 0.06 * currentIntensity) + 2;
        const offsetX = (Math.random() - 0.5) * 60 * currentIntensity;

        try {
          context.drawImage(offscreenCanvas, 0, y, width, bandHeight, offsetX, y, width, bandHeight);
        } catch (error) {
          // Ignorar frame inválido durante resize/carga.
        }

        if (Math.random() < 0.55 * currentIntensity) {
          const rgbOffset = (Math.random() - 0.5) * 16 * currentIntensity;

          context.save();
          context.globalCompositeOperation = 'screen';
          context.globalAlpha = 0.32 * currentIntensity * Math.random();
          context.filter = 'saturate(9999%) hue-rotate(210deg)';

          try {
            context.drawImage(
              offscreenCanvas,
              0,
              y,
              width,
              bandHeight,
              offsetX + rgbOffset,
              y,
              width,
              bandHeight,
            );
          } catch (error) {
            // Ignorar frame inválido durante resize/carga.
          }

          context.restore();

          context.save();
          context.globalCompositeOperation = 'screen';
          context.globalAlpha = 0.18 * currentIntensity * Math.random();
          context.filter = 'saturate(9999%) hue-rotate(330deg)';

          try {
            context.drawImage(
              offscreenCanvas,
              0,
              y,
              width,
              bandHeight,
              offsetX - rgbOffset * 0.8,
              y,
              width,
              bandHeight,
            );
          } catch (error) {
            // Ignorar frame inválido durante resize/carga.
          }

          context.restore();
        }
      }

      if (Math.random() < 0.3 * currentIntensity) {
        const safeWidth = Math.max(1, Math.floor(width));
        const safeHeight = Math.max(1, Math.ceil(Math.random() * 3 + 1));
        const y = Math.floor(Math.random() * height);
        const imageData = context.createImageData(safeWidth, safeHeight);

        for (let i = 0; i < imageData.data.length; i += 4) {
          const value = Math.random() * 255;

          imageData.data[i] = value * 0.1;
          imageData.data[i + 1] = value * 0.3;
          imageData.data[i + 2] = value;
          imageData.data[i + 3] = Math.random() * 110 * currentIntensity;
        }

        context.putImageData(imageData, 0, y);
      }

      if (Math.random() < 0.25 * currentIntensity) {
        context.fillStyle = `rgba(59, 130, 246, ${Math.random() * 0.35 * currentIntensity})`;
        context.fillRect(0, Math.random() * height, width, Math.random() * 2 + 0.5);
      }
    }

    function loop() {
      requestAnimationFrame(loop);

      const targetIntensity = hovering ? 0.55 + Math.random() * 0.35 : 0;
      intensity += (targetIntensity - intensity) * 0.16;

      if (intensity > 0.015) {
        frame++;

        if (frame % 2 === 0) {
          render(intensity);
        }
      } else {
        context.clearRect(0, 0, width, height);
        intensity = 0;
      }
    }

    card.addEventListener('mouseenter', () => {
      hovering = true;
      drawOffscreen();
    });

    card.addEventListener('mouseleave', () => {
      hovering = false;
    });

    if (image.complete) {
      resize();
    } else {
      image.addEventListener('load', resize);
    }

    window.addEventListener('resize', () => {
      setTimeout(resize, 150);
    });

    loop();
  });
}

/* ==========================================================================
   Init
   ========================================================================== */

document.addEventListener('DOMContentLoaded', () => {
  initDeminaClock();
  initDeminaTextGlitch();
  initDeminaCursorTrail();
  initDeminaSpaceCardGlitch();
});