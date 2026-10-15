<?php defined('BASEPATH') OR exit('No direct script access allowed');

$line_url = 'https://line.me/ti/p/DdiEEvzWap';

if (!function_exists('rt_esc')) { function rt_esc($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
} }
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="北灣町訂房須知：貼心服務、匯款資訊、入住規定與取消訂房訂金退還標準。">
    <meta name="theme-color" content="#f8f6ef">
    <title>訂房須知｜北灣町・慢旅小宿</title>
    <script>document.documentElement.classList.add('js');</script>
    <link rel="stylesheet" href="/css/slow-stay.css">
    <link rel="stylesheet" href="/css/room.css">
    <link rel="stylesheet" href="/css/notice.css">
</head>
<body class="rt-page">
    <!-- 手繪風 icon -->
    <svg width="0" height="0" style="position:absolute" aria-hidden="true">
        <symbol id="i-heart" viewBox="0 0 32 32"><path d="M16 27.2c-6.4-4.3-11.6-8.9-11.8-14.2-.1-3.8 2.6-6.8 6-6.9 2.6-.1 4.6 1.5 5.7 3.6 1.1-2.2 3.2-3.8 5.8-3.6 3.4.2 6.2 3.3 5.9 7.1-.4 5.2-5.3 9.6-11.6 14Z"/></symbol>
        <symbol id="i-bank" viewBox="0 0 32 32"><path d="M3.9 12.4 16.1 4.6l12 7.9"/><path d="M4.4 12.6c7.8-.3 15.6-.2 23.3.1"/><path d="M7.6 15.8v8.6M13.2 15.6l.1 8.9M18.8 15.7v8.8M24.3 15.8v8.6"/><path d="M3.6 27.6c8.3-.4 16.6-.3 24.9.1"/></symbol>
        <symbol id="i-note" viewBox="0 0 32 32"><path d="M7.1 4.3c5.9-.3 11.5-.2 17.4.2.4 7.8.3 15.6-.1 23.4-5.8.3-11.6.2-17.4-.1-.3-7.9-.3-15.7.1-23.5Z"/><path d="M11.2 11.1c3.4-.2 6.6-.2 9.9.1M11.1 16.2c3.4-.2 6.7-.1 10 .1M11.3 21.3c2.2-.2 4.2-.1 6.3 0"/></symbol>
        <symbol id="i-check" viewBox="0 0 32 32"><path d="M5.6 16.9c2.8 2.3 5 4.6 7 7.4 4-6.6 8.7-12.1 14-16.7"/></symbol>
        <symbol id="i-copy" viewBox="0 0 32 32"><path d="M11.2 10.9c4.9-.2 9.9-.2 14.8.1.3 5 .2 10.1-.1 15.1-4.9.3-9.8.2-14.7-.1-.2-5-.2-10.1 0-15.1Z"/><path d="M6.4 21.3c-.3-5.1-.2-10.2 0-15.2 4.8-.3 9.7-.2 14.5.1"/></symbol>
        <symbol id="i-arrow" viewBox="0 0 32 32"><path d="M5.4 16.4c6.9-.6 13.9-.5 20.9.1"/><path d="M19.6 9.3c2.5 2.6 4.7 4.8 6.9 7.1-2.4 2.1-4.6 4.3-6.7 6.8"/></symbol>
        <symbol id="i-squiggle" viewBox="0 0 120 12"><path d="M2 8.2c9.6-5.2 17.4 3.6 27.6-.6 9.8-4 17.8 3.9 28.2-.2 10.2-4 18 3.6 28.4-.1 10.2-3.6 19.4 2.8 31.8-1.6"/></symbol>
    </svg>

    <a class="skip-link" href="#main-content">跳至主要內容</a>
    <header class="site-header">
        <div class="header-inner">
            <a class="brand" href="/" aria-label="北灣町・慢旅小宿首頁">
                <svg class="brand-mark" viewBox="0 0 48 48" aria-hidden="true">
                    <path d="M5 22.5 24 7l19 15.5v20H29V29H19v13H5z"/>
                    <path d="M18 17h12"/>
                </svg>
                <span class="brand-copy">
                    <span class="brand-name">北灣町・慢旅小宿</span>
                    <span class="brand-tagline">BEI WAN TING <i></i> STAY SLOW, SLEEP WELL</span>
                </span>
            </a>
            <nav class="main-nav" aria-label="主要導覽">
                <a href="/#about">認識北灣町</a>
                <a href="/room">空間與房型</a>
                <a href="/notice" aria-current="page">訂房須知</a>
                <a class="nav-booking" href="<?= $line_url ?>" target="_blank" rel="noopener">預約包棟 <span aria-hidden="true">↗</span></a>
            </nav>
        </div>
    </header>

    <main id="main-content">
        <section class="rt-intro" aria-labelledby="nt-title">
            <p class="eyebrow" data-reveal>BEFORE YOU ARRIVE</p>
            <h1 id="nt-title" data-reveal>訂房須知</h1>
            <svg class="rt-squiggle" aria-hidden="true" data-reveal><use href="#i-squiggle"/></svg>
            <p class="rt-intro-lead" data-reveal>以誠摯熱烈的心情迎接即將來訪的旅客，<br class="rt-br">邀您一同探索宜蘭之美。</p>
            <nav class="rt-picker" aria-label="頁面快速選單" data-reveal>
                <a href="#service"><b>01</b>貼心服務</a>
                <a href="#payment"><b>02</b>匯款資訊</a>
                <a href="#rules"><b>03</b>住宿規定</a>
                <a href="#refund"><b>04</b>取消訂房</a>
            </nav>
        </section>

        <div class="nt-list">
            <!-- 貼心服務 -->
            <section class="nt-card" id="service" aria-labelledby="service-title" data-reveal>
                <header class="nt-head">
                    <span class="rt-icon rt-icon--lg" aria-hidden="true"><svg><use href="#i-heart"/></svg></span>
                    <div>
                        <p class="eyebrow">THOUGHTFUL SERVICES · 01</p>
                        <h2 id="service-title">貼心服務</h2>
                    </div>
                </header>
                <div class="nt-service">
                    <ul class="nt-checks">
                        <?php foreach ($services as $item): ?>
                        <li><svg aria-hidden="true"><use href="#i-check"/></svg><?= rt_esc($item) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="nt-amenities">
                        <h3>服務與設施</h3>
                        <ul class="nt-chips">
                            <?php foreach ($amenities as $item): ?>
                            <li><?= rt_esc($item) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- 匯款資訊 -->
            <section class="nt-card" id="payment" aria-labelledby="payment-title" data-reveal>
                <header class="nt-head">
                    <span class="rt-icon rt-icon--lg" aria-hidden="true"><svg><use href="#i-bank"/></svg></span>
                    <div>
                        <p class="eyebrow">PAYMENT · 02</p>
                        <h2 id="payment-title">匯款資訊</h2>
                    </div>
                </header>
                <div class="nt-payment">
                    <dl class="nt-bank">
                        <?php foreach ($bank as $row): ?>
                        <div>
                            <dt><?= rt_esc($row['label']) ?></dt>
                            <dd>
                                <span<?= !empty($row['copy']) ? ' class="nt-account"' : '' ?>><?= rt_esc($row['value']) ?></span>
                                <?php if (!empty($row['copy'])): ?>
                                <button class="nt-copy" type="button" data-copy="<?= rt_esc($row['value']) ?>"><svg aria-hidden="true"><use href="#i-copy"/></svg><span>複製帳號</span></button>
                                <?php endif; ?>
                            </dd>
                        </div>
                        <?php endforeach; ?>
                    </dl>
                    <ul class="nt-steps">
                        <li>訂房確認後，請於 <strong>1日內</strong> 預付房價 <strong>50%</strong> 訂金，逾期恕不保留客房，不便處請見諒。</li>
                        <li>匯款完成後，煩請來電告知帳號末五碼，金額、姓名、電話、住房日、房型、人數...方便為您查詢是否已入帳，謝謝。</li>
                        <li>預訂春節客房，請 <strong>預付房價全額之訂金</strong>，謝謝您。</li>
                    </ul>
                </div>
            </section>

            <!-- 住宿規定 -->
            <section class="nt-card" id="rules" aria-labelledby="rules-title" data-reveal>
                <header class="nt-head">
                    <span class="rt-icon rt-icon--lg" aria-hidden="true"><svg><use href="#i-note"/></svg></span>
                    <div>
                        <p class="eyebrow">HOUSE RULES · 03</p>
                        <h2 id="rules-title">住宿規定</h2>
                    </div>
                </header>
                <div class="nt-times">
                    <div><span>CHECK-IN</span><b>15:00</b><small>當日下午以後</small></div>
                    <div><span>CHECK-OUT</span><b>11:00</b><small>隔日上午以前</small></div>
                    <div class="nt-times-tag">全面禁菸</div>
                </div>
                <ol class="nt-rules">
                    <?php foreach ($rules as $rule): ?>
                    <li><?= rt_esc($rule) ?></li>
                    <?php endforeach; ?>
                </ol>
            </section>

            <!-- 取消訂房 -->
            <section class="nt-card" id="refund" aria-labelledby="refund-title" data-reveal>
                <header class="nt-head">
                    <span class="rt-icon rt-icon--lg" aria-hidden="true"><svg><use href="#i-arrow"/></svg></span>
                    <div>
                        <p class="eyebrow">CANCELLATION · 04</p>
                        <h2 id="refund-title">取消訂房訂金退還標準</h2>
                    </div>
                </header>
                <p class="nt-sub">依據交通部觀光局規定</p>
                <ul class="nt-refund">
                    <?php foreach ($refunds as $r): ?>
                    <li style="--p: <?= (int) $r['percent'] ?>%">
                        <span class="nt-refund-when"><?= rt_esc($r['when']) ?></span>
                        <span class="nt-refund-bar" aria-hidden="true"><i></i></span>
                        <span class="nt-refund-val"><?= $r['percent'] === 100 ? '全額退還' : ($r['percent'] === 0 ? '不退回訂金' : '退回 ' . $r['percent'] . '%') ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <ul class="nt-remarks">
                    <li>取消訂房：凡於住房當日未辦理入住者，視同取消訂房。</li>
                    <li>住宿當日，如遇天災(颱風、地震)，經當地政府或旅客所在地政府發布停止上班上課判定準則，可退還全額訂金或保留訂金。</li>
                </ul>
            </section>

            <aside class="rt-card rt-card--cta nt-cta" aria-labelledby="nt-cta-title" data-reveal>
                <p class="eyebrow eyebrow-light">ANY QUESTIONS?</p>
                <h2 id="nt-cta-title">還有問題，歡迎直接問我們</h2>
                <p>電話 0982-016-753（09:00AM~06:00PM）<br>宜蘭縣頭城鎮環鎮東路2段93巷18號</p>
                <div class="rt-actions">
                    <a class="rt-btn rt-btn--light" href="<?= $line_url ?>" target="_blank" rel="noopener">LINE 聯絡訂房 <svg><use href="#i-arrow"/></svg></a>
                    <a class="rt-btn rt-btn--outline" href="tel:0982016753">撥打電話</a>
                </div>
            </aside>
        </div>
    </main>

    <footer class="site-footer">
        <div class="footer-main">
            <a class="brand brand-footer" href="/" aria-label="回到北灣町首頁">
                <svg class="brand-mark" viewBox="0 0 48 48" aria-hidden="true"><path d="M5 22.5 24 7l19 15.5v20H29V29H19v13H5z"/><path d="M18 17h12"/></svg>
                <span class="brand-copy"><span class="brand-name">北灣町・慢旅小宿</span><span class="brand-tagline">BEI WAN TING <i></i> STAY SLOW, SLEEP WELL</span></span>
            </a>
            <p>把風景留給沿途，把時間留給相聚，<br>把舒服的時光留在北灣町。</p>
        </div>
        <div class="footer-bottom"><span>© 2026 北灣町・慢旅小宿</span><span>宜蘭頭城｜自在休息，慢慢旅行。</span></div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/motion@11.11.13/dist/motion.js"></script>
    <script src="/js/notice.js"></script>
</body>
</html>
