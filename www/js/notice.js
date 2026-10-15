(function () {
    'use strict';

    var root = document.documentElement;
    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var Motion = window.Motion;
    var EASE = [0.22, 1, 0.36, 1];

    /* ---------- 滾動淡入 (framer-motion / Motion) ---------- */
    if (!Motion || reduceMotion) {
        // 沒載入動畫庫或使用者偏好減少動態時，直接顯示內容
        root.classList.remove('js');
    } else {
        var animate = Motion.animate;
        var stagger = Motion.stagger;

        animate('.rt-intro [data-reveal]', { opacity: [0, 1], y: [24, 0] }, {
            duration: 0.8,
            ease: EASE,
            delay: stagger(0.1)
        });

        Motion.inView('.nt-list [data-reveal]', function (info) {
            var card = info.target || info;
            animate(card, { opacity: [0, 1], y: [48, 0] }, { duration: 0.9, ease: EASE });

            var bars = card.querySelectorAll('.nt-refund-bar i');
            if (bars.length) {
                animate(bars, { scaleX: [0, 1] }, {
                    duration: 0.9,
                    ease: EASE,
                    delay: stagger(0.08, { startDelay: 0.3 })
                });
            }
        }, { amount: 0.15 });
    }

    /* ---------- 複製匯款帳號 ---------- */
    document.querySelectorAll('[data-copy]').forEach(function (btn) {
        var label = btn.querySelector('span');
        var original = label.textContent;

        btn.addEventListener('click', function () {
            var text = btn.getAttribute('data-copy');
            var done = function () {
                btn.classList.add('is-copied');
                label.textContent = '已複製';
                setTimeout(function () {
                    btn.classList.remove('is-copied');
                    label.textContent = original;
                }, 1800);
            };

            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(done);
            } else {
                // http 環境沒有 clipboard API，改用暫時的 textarea
                var ta = document.createElement('textarea');
                ta.value = text;
                ta.setAttribute('readonly', '');
                ta.style.position = 'absolute';
                ta.style.left = '-9999px';
                document.body.appendChild(ta);
                ta.select();
                try { document.execCommand('copy'); done(); } catch (e) {}
                document.body.removeChild(ta);
            }
        });
    });
})();
