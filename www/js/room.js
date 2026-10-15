(function () {
    'use strict';

    var root = document.documentElement;
    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var Motion = window.Motion;
    var EASE = [0.22, 1, 0.36, 1];

    /* ---------- 圖片輪播 (Swiper) ---------- */
    if (window.Swiper) {
        document.querySelectorAll('.rt-swiper').forEach(function (el) {
            new Swiper(el, {
                loop: true,
                speed: reduceMotion ? 0 : 650,
                grabCursor: true,
                navigation: {
                    prevEl: el.querySelector('.rt-nav--prev'),
                    nextEl: el.querySelector('.rt-nav--next')
                },
                pagination: {
                    el: el.querySelector('.rt-dots'),
                    clickable: true,
                    bulletClass: 'rt-dot',
                    bulletActiveClass: 'is-active'
                },
                keyboard: { enabled: true, onlyInViewport: true },
                a11y: {
                    prevSlideMessage: '上一張',
                    nextSlideMessage: '下一張',
                    paginationBulletMessage: '第 {{index}} 張'
                }
            });
        });
    }

    /* ---------- 滾動淡入 (framer-motion / Motion) ---------- */
    if (!Motion || reduceMotion) {
        // 沒載入動畫庫或使用者偏好減少動態時，直接顯示內容
        root.classList.remove('js');
    } else {
        var animate = Motion.animate;
        var stagger = Motion.stagger;

        // 頁首標題區：依序淡入
        animate('.rt-intro [data-reveal]', { opacity: [0, 1], y: [24, 0] }, {
            duration: 0.8,
            ease: EASE,
            delay: stagger(0.1)
        });

        // 卡片：進入視窗時淡入 + 上移，內文再錯開出現
        Motion.inView('.rt-list [data-reveal]', function (info) {
            var card = info.target || info;
            animate(card, { opacity: [0, 1], y: [48, 0] }, { duration: 0.9, ease: EASE });

            var parts = card.querySelectorAll('.rt-body > *, .rt-card--cta > *');
            if (parts.length) {
                animate(parts, { opacity: [0, 1], y: [16, 0] }, {
                    duration: 0.7,
                    ease: EASE,
                    delay: stagger(0.07, { startDelay: 0.2 })
                });
            }
        }, { amount: 0.2 });
    }

    /* ---------- 房型詳情 dialog ---------- */
    function openDialog(dialog) {
        if (typeof dialog.showModal !== 'function') return;
        dialog.showModal();
        document.body.classList.add('rt-locked');
        if (Motion && !reduceMotion) {
            Motion.animate(dialog.querySelector('.rt-dialog-panel'),
                { opacity: [0, 1], y: [30, 0], scale: [0.97, 1] },
                { duration: 0.45, ease: EASE });
        }
    }

    function closeDialog(dialog) {
        var done = function () {
            dialog.close();
            document.body.classList.remove('rt-locked');
        };
        if (Motion && !reduceMotion) {
            Motion.animate(dialog.querySelector('.rt-dialog-panel'),
                { opacity: 0, y: 20 },
                { duration: 0.22, ease: 'easeIn' }).then(done);
        } else {
            done();
        }
    }

    document.querySelectorAll('[data-dialog]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var dialog = document.getElementById(btn.getAttribute('data-dialog'));
            if (dialog) openDialog(dialog);
        });
    });

    document.querySelectorAll('.rt-dialog').forEach(function (dialog) {
        dialog.querySelector('.rt-dialog-close').addEventListener('click', function () {
            closeDialog(dialog);
        });
        // 點擊遮罩關閉
        dialog.addEventListener('click', function (e) {
            if (e.target === dialog) closeDialog(dialog);
        });
        // Esc 關閉時也跑離場動畫
        dialog.addEventListener('cancel', function (e) {
            e.preventDefault();
            closeDialog(dialog);
        });
    });
})();
