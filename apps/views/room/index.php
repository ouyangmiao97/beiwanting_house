<?php defined('BASEPATH') OR exit('No direct script access allowed');

$line_url = 'https://line.me/ti/p/DdiEEvzWap';
$price_labels = array('平日', '旺日', '假日', '定價');

// 依 layout 分組：full 獨佔一列，連續的 half 兩兩成對
$rows = array();
foreach ($rooms as $room) {
    $last = count($rows) - 1;
    if ($room['layout'] === 'half' && $last >= 0 && $rows[$last]['type'] === 'pair' && count($rows[$last]['rooms']) < 2) {
        $rows[$last]['rooms'][] = $room;
    } else {
        $rows[] = array('type' => $room['layout'] === 'half' ? 'pair' : 'full', 'rooms' => array($room));
    }
}

$full_count = 0;

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
    <meta name="description" content="北灣町客房介紹：豪華雙人間、雙人套房與四人套房，房價、住宿內容與房內設施一次看。">
    <meta name="theme-color" content="#f8f6ef">
    <title>空間與房型｜北灣町・慢旅小宿</title>
    <script>document.documentElement.classList.add('js');</script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11.1.14/swiper-bundle.min.css">
    <link rel="stylesheet" href="/css/slow-stay.css">
    <link rel="stylesheet" href="/css/room.css">
</head>
<body class="rt-page">
    <!-- 手繪風 icon -->
    <svg width="0" height="0" style="position:absolute" aria-hidden="true">
        <symbol id="i-guests" viewBox="0 0 32 32"><path d="M11.6 13.4c-2.4.1-4-1.8-3.9-4.1.1-2.2 1.9-3.9 4-3.8 2.2.1 3.8 2 3.7 4.2-.1 2.1-1.7 3.7-3.8 3.7Z"/><path d="M4.3 26.2c.2-4.6 3.3-8.2 7.6-8.1 4.2.1 7 3.6 7.1 8.3"/><path d="M21.4 14.6c-1.8 0-3-1.4-2.9-3.2.1-1.7 1.4-2.9 3-2.8 1.7.1 2.9 1.5 2.8 3.2-.1 1.6-1.3 2.8-2.9 2.8Z"/><path d="M21.6 18.3c3.4 0 5.9 2.8 6.1 6.6"/></symbol>
        <symbol id="i-extra" viewBox="0 0 32 32"><path d="M3.8 24.6V9.3"/><path d="M3.9 19.2c7.6-.3 16.4-.2 24.2.1v5.4"/><path d="M4.1 15.1c1.1-2.4 4.6-2.6 5.9-.2"/><path d="M12.6 15.3c3.9-.7 9.6-.6 13.5.4 1.3.4 2 1.6 2 3.4"/><path d="M23.4 4.1v8.2M19.3 8.3h8.3"/></symbol>
        <symbol id="i-tub" viewBox="0 0 32 32"><path d="M3.6 15.8c8.3-.4 16.6-.3 24.8.1"/><path d="M5.1 16.1c-.2 5.1 2.4 8.4 7 8.6 3 .1 6.1.2 8.9-.1 4.4-.4 6.4-3.6 6.2-8.4"/><path d="M8.2 24.4l-1.4 3M24 24.3l1.3 3"/><path d="M7.8 15.6V7.2c0-2.1 1.5-3.4 3.3-3.3 1.6.1 2.6 1.1 2.8 2.6"/><circle cx="18.6" cy="10.4" r="1.4"/><circle cx="22.8" cy="7.6" r="1.1"/><circle cx="23.4" cy="12.2" r=".9"/></symbol>
        <symbol id="i-balcony" viewBox="0 0 32 32"><path d="M3.9 17.4c8.2-.4 16.1-.3 24.3.2"/><path d="M4.2 27.6c8-.3 15.9-.2 23.9.1"/><path d="M7.6 17.7v9.6M12.4 17.6v9.8M17.2 17.5l.1 9.9M22 17.7v9.7M26.4 17.8v9.6"/><circle cx="21.3" cy="8.1" r="3"/><path d="M21.4 1.9v1.6M27.4 8.2h-1.7M25.6 3.8l-1.2 1.1M16.9 3.9l1.1 1.1"/></symbol>
        <symbol id="i-coffee" viewBox="0 0 32 32"><path d="M5.2 13.4c5.7-.4 11.6-.3 17.2.1-.2 6.3-1.6 11.9-8.4 12-6.9.1-8.6-5.6-8.8-12.1Z"/><path d="M22.2 15.3c2.9-.8 5.3.6 5 3.1-.3 2.6-3.2 3.4-6.1 2.6"/><path d="M3.6 28.3c7.5-.4 14.4-.4 21.3.1"/><path d="M10.4 9.6c-1.4-1.6.9-2.8-.3-4.6M15.2 9.5c-1.4-1.7.9-2.9-.4-4.8"/></symbol>
        <symbol id="i-house" viewBox="0 0 32 32"><path d="M3.8 15.4 16.1 4.3l12.2 11.2"/><path d="M7.2 12.8c-.3 4.7-.2 9.6.1 14.6 5.9.3 11.8.3 17.6-.1.3-4.9.3-9.7 0-14.5"/><path d="M16 23.9c-3.3-2.2-5-4-4.9-5.9.1-1.5 1.4-2.5 2.8-2.3 1 .1 1.7.8 2.1 1.6.4-.9 1.2-1.6 2.3-1.6 1.4 0 2.6 1.2 2.4 2.6-.2 1.8-2 3.6-4.7 5.6Z"/></symbol>
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
                <a href="/room" aria-current="page">空間與房型</a>
                <a href="/notice">訂房須知</a>
                <a class="nav-booking" href="<?= $line_url ?>" target="_blank" rel="noopener">預約包棟 <span aria-hidden="true">↗</span></a>
            </nav>
        </div>
    </header>

    <main id="main-content">
        <section class="rt-intro" aria-labelledby="rt-title">
            <p class="eyebrow" data-reveal>ROOMS FOR SLOW DAYS</p>
            <h1 id="rt-title" data-reveal>空間與房型</h1>
            <svg class="rt-squiggle" aria-hidden="true" data-reveal><use href="#i-squiggle"/></svg>
            <p class="rt-intro-lead" data-reveal>五間各有風格的客房，雙人房型可加人加床，<br class="rt-br">親子同遊、家庭旅行都住得舒服。</p>
            <nav class="rt-picker" aria-label="房型快速選單" data-reveal>
                <?php foreach ($rooms as $room): ?>
                <a href="#room-<?= $room['id'] ?>"><b><?= $room['code'] ?></b><?= rt_esc($room['name']) ?></a>
                <?php endforeach; ?>
            </nav>
        </section>

        <div class="rt-list">
            <?php foreach ($rows as $row): ?>
            <div class="rt-row rt-row--<?= $row['type'] ?>">
                <?php foreach ($row['rooms'] as $room):
                    $is_full = $row['type'] === 'full';
                    $reverse = $is_full && ($full_count++ % 2 === 1);
                ?>
                <article class="rt-card rt-card--<?= $is_full ? 'full' : 'half' ?><?= $reverse ? ' rt-card--reverse' : '' ?>" id="room-<?= $room['id'] ?>" aria-labelledby="room-<?= $room['id'] ?>-title" data-reveal>
                    <div class="rt-media">
                        <div class="swiper rt-swiper">
                            <div class="swiper-wrapper">
                                <?php foreach ($room['images'] as $i => $src): ?>
                                <div class="swiper-slide">
                                    <img src="<?= rt_esc($src) ?>" alt="<?= $room['code'] . rt_esc($room['name']) ?> 房間照片 <?= $i + 1 ?>" loading="<?= $i === 0 ? 'eager' : 'lazy' ?>">
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <button class="rt-nav rt-nav--prev" type="button" aria-label="上一張"><svg><use href="#i-arrow"/></svg></button>
                            <button class="rt-nav rt-nav--next" type="button" aria-label="下一張"><svg><use href="#i-arrow"/></svg></button>
                            <div class="rt-dots"></div>
                        </div>
                        <span class="rt-sticker" aria-hidden="true"><?= $room['code'] ?></span>
                    </div>

                    <div class="rt-body">
                        <p class="eyebrow"><?= strtoupper($room['en']) ?> · <?= $room['code'] ?></p>
                        <h2 id="room-<?= $room['id'] ?>-title"><?= rt_esc($room['name']) ?></h2>
                        <p class="rt-style"><?= rt_esc($room['style']) ?></p>
                        <ul class="rt-icons">
                            <li><span class="rt-icon"><svg><use href="#i-guests"/></svg></span><?= $room['guests'] ?> 人入住</li>
                            <li><span class="rt-icon"><svg><use href="#i-extra"/></svg></span>可加 <?= $room['extra'] ?> 人</li>
                            <?php foreach ($room['features'] as $f): ?>
                            <li><span class="rt-icon"><svg><use href="#i-<?= $f ?>"/></svg></span><?= rt_esc($features[$f]) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <p class="rt-desc"><?= rt_esc($room['desc']) ?></p>
                        <p class="rt-price">平日 <span>NT$ <?= number_format($room['prices'][0]) ?></span> 起・一泊二食</p>
                        <div class="rt-actions">
                            <button class="rt-btn rt-btn--solid" type="button" data-dialog="dialog-<?= $room['id'] ?>">查看詳情 <svg><use href="#i-arrow"/></svg></button>
                            <a class="rt-btn rt-btn--ghost" href="<?= $line_url ?>" target="_blank" rel="noopener">LINE 預約</a>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>

                <?php if ($row['type'] === 'pair' && count($row['rooms']) === 1): ?>
                <aside class="rt-card rt-card--cta" aria-labelledby="rt-cta-title" data-reveal>
                    <span class="rt-icon rt-icon--lg" aria-hidden="true"><svg><use href="#i-house"/></svg></span>
                    <p class="eyebrow eyebrow-light">THE WHOLE HOUSE IS YOURS</p>
                    <h2 id="rt-cta-title">包下整棟，<br>最多 26 人同住</h2>
                    <p>客廳、廚房、KTV 與頂樓露台都是你們的。家族旅行、好友聚會，一起把時間留給相聚。</p>
                    <div class="rt-actions">
                        <a class="rt-btn rt-btn--light" href="<?= $line_url ?>" target="_blank" rel="noopener">詢問包棟 <svg><use href="#i-arrow"/></svg></a>
                        <a class="rt-btn rt-btn--outline" href="https://beiwanting.elbnb.com/news.php?id=729" target="_blank" rel="noopener">包棟房價資訊</a>
                    </div>
                </aside>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>

        <p class="image-disclaimer">部分照片為空間風格參考，實際房型與設備請以現場為準。</p>
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

    <?php foreach ($rooms as $room): ?>
    <dialog class="rt-dialog" id="dialog-<?= $room['id'] ?>" aria-labelledby="dialog-<?= $room['id'] ?>-title">
        <div class="rt-dialog-panel">
            <button class="rt-dialog-close" type="button" aria-label="關閉">&times;</button>
            <p class="eyebrow"><?= $room['code'] ?> · <?= rt_esc($room['style']) ?></p>
            <h2 id="dialog-<?= $room['id'] ?>-title"><?= $room['code'] ?>．<?= rt_esc($room['name']) ?></h2>

            <h3>房價列表</h3>
            <div class="rt-table-wrap">
                <table class="rt-table">
                    <thead>
                        <tr><th scope="col">房間型態</th><?php foreach ($price_labels as $label): ?><th scope="col"><?= $label ?></th><?php endforeach; ?></tr>
                    </thead>
                    <tbody>
                        <tr><th scope="row"><?= rt_esc($room['name']) ?></th><?php foreach ($room['prices'] as $p): ?><td><?= number_format($p) ?></td><?php endforeach; ?></tr>
                        <tr><th scope="row">加人/加床(含餐)</th><?php foreach ($price_labels as $label): ?><td>1,250/人</td><?php endforeach; ?></tr>
                    </tbody>
                </table>
            </div>
            <ul class="rt-notes">
                <li>此房型可加 <?= $room['extra'] ?> 人。</li>
                <li>一泊二食：早餐＋中餐或晚餐（二擇一）。</li>
                <li>中餐/晚餐：頭城知名排隊名店「龍記牛肉麵」套餐。</li>
                <li>平日：週一至週四。旺日：週五、週日、暑假期間平日、連續假日前一晚。假日：週六及連續假日。</li>
                <li>定價：國定假日（元旦/農曆春節/228/兒童節/清明節/勞動節/端午節/中秋節/教師節/國慶日/光復節/行憲紀念日）。</li>
                <li>包棟：最多可入住 26 人。</li>
            </ul>

            <h3>房內設施</h3>
            <ul class="rt-facilities">
                <?php foreach ($facilities as $item): ?>
                <li><?= rt_esc($item) ?></li>
                <?php endforeach; ?>
            </ul>
            <p class="rt-facility-note">提供茶包、膠囊咖啡及礦泉水，備有舒眠精油香薰。</p>

            <div class="rt-actions">
                <a class="rt-btn rt-btn--solid" href="<?= $line_url ?>" target="_blank" rel="noopener">LINE 預約此房型 <svg><use href="#i-arrow"/></svg></a>
            </div>
        </div>
    </dialog>
    <?php endforeach; ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11.1.14/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/motion@11.11.13/dist/motion.js"></script>
    <script src="/js/room.js"></script>
</body>
</html>
