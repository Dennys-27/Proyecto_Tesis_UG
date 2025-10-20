// app.js — versión robusta y defensiva
document.addEventListener('DOMContentLoaded', () => {

  /* ---------------------------
     Canvas de partículas (si no existe)
     --------------------------- */
  (function setupCanvasParticles(){
    // crear canvas sólo si no existe
    let canvas = document.getElementById('bgCanvas');
    if (!canvas) {
      canvas = document.createElement('canvas');
      canvas.id = 'bgCanvas';
      document.body.insertBefore(canvas, document.body.firstChild);
    }
    const ctx = canvas.getContext ? canvas.getContext('2d') : null;
    if (!ctx) return; // entorno sin canvas 2d (muy raro)

    function resizeCanvas(){
      canvas.width = window.innerWidth;
      canvas.height = window.innerHeight;
    }
    resizeCanvas();

    let particlesArray = [];

    class Particle {
      constructor(x, y, size, speedX, speedY) {
        this.x = x; this.y = y; this.size = size;
        this.speedX = speedX; this.speedY = speedY;
      }
      update() {
        this.x += this.speedX;
        this.y += this.speedY;
        if (this.x > canvas.width || this.x < 0) this.speedX *= -1;
        if (this.y > canvas.height || this.y < 0) this.speedY *= -1;
      }
      draw() {
        ctx.fillStyle = 'rgba(59,87,249,0.7)';
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
        ctx.fill();
      }
    }

    function initParticles(){
      particlesArray = [];
      const numberOfParticles = 80;
      for (let i = 0; i < numberOfParticles; i++) {
        let size = Math.random() * 3 + 1;
        let x = Math.random() * canvas.width;
        let y = Math.random() * canvas.height;
        let speedX = (Math.random() - 0.5) * 1;
        let speedY = (Math.random() - 0.5) * 1;
        particlesArray.push(new Particle(x, y, size, speedX, speedY));
      }
    }

    function connectParticles() {
      for (let a = 0; a < particlesArray.length; a++) {
        for (let b = a; b < particlesArray.length; b++) {
          let dx = particlesArray[a].x - particlesArray[b].x;
          let dy = particlesArray[a].y - particlesArray[b].y;
          let distance = Math.sqrt(dx * dx + dy * dy);
          if (distance < 120) {
            ctx.strokeStyle = 'rgba(59,87,249,0.2)';
            ctx.lineWidth = 1;
            ctx.beginPath();
            ctx.moveTo(particlesArray[a].x, particlesArray[a].y);
            ctx.lineTo(particlesArray[b].x, particlesArray[b].y);
            ctx.stroke();
          }
        }
      }
    }

    function animate() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      particlesArray.forEach(p => { p.update(); p.draw(); });
      connectParticles();
      requestAnimationFrame(animate);
    }

    window.addEventListener('resize', () => {
      resizeCanvas();
      initParticles();
    }, { passive: true });

    initParticles();
    animate();
  })();

  /* ---------------------------
     Restablecer contraseña (toggle, validación y modal)
     --------------------------- */
  (function setupResetPassword(){
    const toggle1 = document.getElementById('togglePw1');
    const toggle2 = document.getElementById('togglePw2');
    const pw1 = document.getElementById('pw1');
    const pw2 = document.getElementById('pw2');
    const btn = document.getElementById('btnRestablecer');
    const pw2Help = document.getElementById('pw2Help');
    const pw1Help = document.getElementById('pw1Help');

    const modalEl = document.getElementById('restModal');
    const restLoading = document.getElementById('restLoading');
    const restSuccess = document.getElementById('restSuccess');
    const restError = document.getElementById('restError');

    // si no hay botón de restablecer, saltamos todo este bloque
    if (!btn) return;

    const modal = modalEl ? new bootstrap.Modal(modalEl) : null;

    const ICON_OPEN = '<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg>';
    const ICON_CLOSED = '<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M2 2l20 20"/><path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-5 0-9.27-3.11-11-8 1.05-2.76 2.9-4.96 5.09-6.3"/><path d="M9.53 9.54a3.5 3.5 0 0 0 4.92 4.92"/></svg>';

    // safe init for toggles
    function safeSetToggle(btnEl, inputEl) {
      if (!btnEl || !inputEl) return;
      btnEl.innerHTML = ICON_CLOSED;
      btnEl.addEventListener('click', () => {
        const isPwd = inputEl.type === 'password';
        inputEl.type = isPwd ? 'text' : 'password';
        btnEl.innerHTML = isPwd ? ICON_OPEN : ICON_CLOSED;
        btnEl.setAttribute('aria-pressed', isPwd ? 'true' : 'false');
      });
    }
    safeSetToggle(toggle1, pw1);
    safeSetToggle(toggle2, pw2);

    // small helper
    function shake(el) {
      if (!el) return;
      el.classList.add('shake');
      setTimeout(()=> el.classList.remove('shake'), 420);
    }

    function checkPasswordPolicy(pw){
      if (!pw) return false;
      if (pw.length < 8) return false;
      if (!/[A-Z]/.test(pw)) return false;
      if (!/[0-9]/.test(pw)) return false;
      return true;
    }

    btn.addEventListener('click', () => {
      const a = pw1 ? pw1.value.trim() : '';
      const b = pw2 ? pw2.value.trim() : '';

      if (!checkPasswordPolicy(a)) {
        if (pw1) {
          shake(pw1);
          if (pw1Help) pw1Help.textContent = 'La contraseña debe tener mínimo 8 caracteres, una mayúscula y un número.';
        }
        return;
      }

      if (a !== b) {
        if (pw2Help) pw2Help.classList.remove('d-none');
        if (pw2) shake(pw2);
        return;
      }
      if (pw2Help) pw2Help.classList.add('d-none');

      // modal flow (if present)
      if (restLoading) restLoading.classList.remove('d-none');
      if (restSuccess) restSuccess.classList.add('d-none');
      if (restError) restError.classList.add('d-none');
      if (modal) modal.show();

      setTimeout(() => {
        const ok = true; // simulate
        if (restLoading) restLoading.classList.add('d-none');
        if (ok && restSuccess) restSuccess.classList.remove('d-none');
        if (!ok && restError) restError.classList.remove('d-none');
      }, 900);
    });

  })();

  /* ---------------------------
     Sobre animado + modal de enviar correo
     --------------------------- */
  (function setupFlyingEnvelope(){
    const btn = document.getElementById('btnEnviarCorreo');
    const iconWrap = document.getElementById('correoAnimado');
    const modalEl = document.getElementById('correoModal');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const successBlock = document.getElementById('successMessage');
    const emailInput = document.getElementById('email');
    const burstRoot = document.getElementById('burstRoot');

    if (!btn || !iconWrap || !modalEl || !loadingSpinner || !successBlock || !emailInput || !burstRoot) {
      // Si faltan elementos esenciales, no hacemos nada y salimos.
      return;
    }

    const modal = new bootstrap.Modal(modalEl);

    function isValidEmail(e) {
      return /\S+@\S+\.\S+/.test(e);
    }

    function getCenter(rect) {
      return { x: rect.left + rect.width/2 + window.scrollX, y: rect.top + rect.height/2 + window.scrollY };
    }

    function createBurst(x,y, color) {
      const container = document.createElement('div');
      container.className = 'burst';
      container.style.left = (x - 4) + 'px';
      container.style.top = (y - 4) + 'px';
      burstRoot.appendChild(container);

      const count = 8;
      for (let i=0;i<count;i++){
        const dot = document.createElement('div');
        dot.className = 'dot';
        dot.style.background = color || getComputedStyle(document.documentElement).getPropertyValue('--color-primary') || '#3b57f9';
        container.appendChild(dot);
        const angle = (Math.PI*2) * (i / count) + (Math.random()*0.5 - 0.25);
        const dist = 28 + Math.random()*18;
        dot.style.left = '0px';
        dot.style.top = '0px';
        requestAnimationFrame(()=> {
          dot.style.transform = `translate(${Math.cos(angle)*dist}px, ${Math.sin(angle)*dist}px) scale(1)`;
          dot.style.opacity = 0;
        });
      }
      setTimeout(()=> container.remove(), 700);
    }

    function quadBezier(p0, p1, p2, t){
      const u = 1 - t;
      const x = u*u*p0.x + 2*u*t*p1.x + t*t*p2.x;
      const y = u*u*p0.y + 2*u*t*p1.y + t*t*p2.y;
      return { x, y };
    }

    function flyEnvelope(from, to, duration = 1100) {
      return new Promise((resolve) => {
        const ctrl = { x: (from.x + to.x)/2, y: Math.min(from.y, to.y) - Math.max(120, Math.abs(to.x-from.x)*0.45) };
        const start = performance.now();
        const half = Math.max(10, Math.min(20, (iconWrap.clientWidth||40)/2));
        iconWrap.style.opacity = 1;
        iconWrap.style.transform = 'translate(0,0) scale(1) rotate(0deg)';
        iconWrap.style.left = (from.x - half) + 'px';
        iconWrap.style.top = (from.y - half) + 'px';

        function frame(now) {
          const t = Math.min(1, (now - start) / duration);
          const p = quadBezier(from, ctrl, to, t);
          const rotation = 720 * (t);
          const scale = 1 - 0.7 * (t);
          iconWrap.style.transform = `translate(${p.x - from.x}px, ${p.y - from.y}px) rotate(${rotation}deg) scale(${scale})`;
          if (t > 0.85) {
            iconWrap.style.opacity = `${Math.max(0, 1 - (t-0.85)/0.15)}`;
          }
          if (t < 1) requestAnimationFrame(frame);
          else resolve(p);
        }
        requestAnimationFrame(frame);
      });
    }

    btn.addEventListener('click', async () => {
      const email = emailInput.value.trim();
      if (!isValidEmail(email)) {
        emailInput.classList.add('shake');
        setTimeout(()=> emailInput.classList.remove('shake'), 500);
        return;
      }

      if (loadingSpinner) loadingSpinner.classList.remove('d-none');
      if (successBlock) successBlock.classList.add('d-none');

      const btnRect = btn.getBoundingClientRect();
      const start = getCenter(btnRect);
      const modalContent = document.querySelector('#correoModal .modal-content');
      let to;
      if (modalContent) {
        const mRect = modalContent.getBoundingClientRect();
        if (mRect.width === 0 && mRect.height === 0) {
          to = { x: window.innerWidth/2 + window.scrollX, y: window.innerHeight*0.28 + window.scrollY };
        } else {
          to = { x: mRect.left + mRect.width/2 + window.scrollX, y: mRect.top + mRect.height/2 + window.scrollY };
        }
      } else {
        to = { x: window.innerWidth/2 + window.scrollX, y: window.innerHeight*0.28 + window.scrollY };
      }

      iconWrap.classList.remove('d-none');
      await new Promise(r => setTimeout(r, 30));
      const landed = await flyEnvelope(start, to, 1200);

      createBurst(landed.x, landed.y, getComputedStyle(document.documentElement).getPropertyValue('--color-primary') || '#3b57f9');

      iconWrap.style.opacity = 0;
      setTimeout(()=> iconWrap.classList.add('d-none'), 180);

      modal.show();

      setTimeout(()=>{
        if (loadingSpinner) loadingSpinner.classList.add('d-none');
        if (successBlock) successBlock.classList.remove('d-none');
      }, 650);
    });

  })();

}); // end DOMContentLoaded
