<?php 
if(isset($_GET['poid'])){
$poid = $_GET['poid'];
}

$con = mysqli_connect(DATABASE_HOST,DATABASE_USER,DATABASE_PASSWORD,DATABASE_NAME);

?>

<!DOCTYPE html>
<html>
<head>
<!-- v3.3.2 -->
<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title></title>
<style type="text/css">

    /* Layout Styles */
    .page {
        display: block;
        position: relative;
        overflow: hidden;
        background-color: white;
    }
    
    .page[data-visible="true"].page[data-state="unloaded"]:after,
    .page[data-visible="true"].page[data-state="loading"]:after,
    .page[data-visible="true"].page[data-state="hidden"]:after {
        position: absolute;
        top: 50%;
        left: 50%;
        margin: -12px 0 0 -12px;
        border: 4px solid #bbb;
        border-top: 4px solid #3c9fe1;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        animation: spin 1s linear infinite;
        content: "";
    }
    
    .page-inner {
        -webkit-transform-origin: top left;
        -ms-transform-origin: top left;
        transform-origin: top left;
    }
    
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
    
        100% {
            transform: rotate(360deg);
        }
    }
    
    #idrviewer {
        overflow: auto;
        line-height: 0;
        margin: 0;
        padding: 0;
        -webkit-overflow-scrolling: touch;
    }
    
    #overlay {
        width: 100%;
        height: 100%;
        position: absolute;
        z-index: 10;
        visibility: hidden;
    }
    
    #overlay.panning {
        visibility: visible;
        cursor: all-scroll;
        cursor: -moz-grab;
        cursor: -webkit-grab;
        cursor: grab;
    }
    
    #overlay.panning.mousedown {
        cursor: all-scroll;
        cursor: -moz-grabbing;
        cursor: -webkit-grabbing;
        cursor: grabbing;
    }
    
    /* Highlight Style */
    .highlight {
        background-color: #FFFF0088;
    }
    
    .highlight.selected {
        background-color: #FFA50088;
    }
    
    /* Presentation Layout */
    .layout-presentation .page {
        visibility: hidden;
        position: absolute;
    }
    
    .layout-presentation .page.current {
        visibility: visible !important;
        z-index: 1;
        /* Fix selection in IE/Edge */
    }
    
    /* Continuous Layout */
    .layout-continuous .page {
        margin: 0 auto 10px;
    }
    
    .layout-continuous .page:last-child {
        margin: 0 auto 0;
    }
    
    /* Magazine Layout */
    .layout-magazine .page {
        visibility: hidden;
        position: absolute;
    }
    
    .layout-magazine .page.current {
        visibility: visible !important;
        z-index: 1;
        /* Fix selection in IE/Edge */
    }
    
    /* Slide Transition */
    .layout-presentation.transition-slide .page {
        -webkit-transition: opacity 0.2s, -webkit-transform 0.4s;
        transition: opacity 0.2s, transform 0.4s;
        opacity: 0;
        visibility: visible !important;
    }
    
    .layout-presentation.transition-slide .page.current {
        visibility: visible !important;
        opacity: 1;
    }
    
    .layout-presentation.transition-slide .page.after {
        visibility: visible !important;
        -webkit-transform: translateX(130%);
        transform: translateX(130%);
        -webkit-transition-delay: 0.1s, 0s;
        transition-delay: 0.1s, 0s;
    }
    
    .layout-presentation.transition-slide .page.before {
        visibility: visible !important;
        -webkit-transform: translateX(-130%);
        transform: translateX(-130%);
        -webkit-transition-delay: 0.1s, 0s;
        transition-delay: 0.1s, 0s;
    }
    
    .isR2L.layout-presentation.transition-slide .page.after {
        -webkit-transform: translateX(-130%);
        transform: translateX(-130%);
    }
    
    .isR2L.layout-presentation.transition-slide .page.before {
        -webkit-transform: translateX(130%);
        transform: translateX(130%);
    }
    
    /* Fade Transition */
    .layout-presentation.transition-fade .page {
        -webkit-transition: visibility 0.5s, opacity 0.5s;
        transition: visibility 0.5s, opacity 0.5s;
        opacity: 1;
    }
    
    .layout-presentation.transition-fade .page.prev,
    .layout-presentation.transition-fade .page.next {
        opacity: 0;
        z-index: 2;
    }
    
    /* Flip Transition */
    .layout-presentation.transition-flip>div>div {
        -webkit-transform-style: preserve-3d;
        transform-style: preserve-3d;
        -webkit-perspective: 1000px;
        perspective: 1000px;
    }
    
    .layout-presentation.transition-flip .page {
        -webkit-transition: -webkit-transform 0.5s;
        transition: transform 0.5s;
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
    }
    
    .layout-presentation.transition-flip .page.before {
        -webkit-transform: rotateY(-180deg);
        transform: rotateY(-180deg);
    }
    
    .layout-presentation.transition-flip .page.after {
        -webkit-transform: rotateY(180deg);
        transform: rotateY(180deg);
    }
    
    .layout-presentation.transition-flip .next,
    .layout-presentation.transition-flip .prev {
        visibility: visible;
    }
    
    /* Throw Transition */
    .layout-presentation.transition-throw .page {
        opacity: 0;
        -webkit-transition: -webkit-transform 0.5s, opacity 0.5s;
        transition: transform 0.5s, opacity 0.5s;
        -webkit-transition-timing-function: ease-out;
        transition-timing-function: ease-out;
    }
    
    .layout-presentation.transition-throw .page.current {
        visibility: visible !important;
        z-index: 3;
        opacity: 1;
    }
    
    .layout-presentation.transition-throw .page.prev {
        visibility: visible !important;
        opacity: 0;
        z-index: 4;
    }
    
    .layout-presentation.transition-throw .page.prev:nth-child(even) {
        -webkit-transform: translate(100%, -100%) rotate(240deg);
        transform: translate(100%, -100%) rotate(240deg);
    }
    
    .layout-presentation.transition-throw .page.prev:nth-child(odd) {
        -webkit-transform: translate(-100%, -100%) rotate(-240deg);
        transform: translate(-100%, -100%) rotate(-240deg);
    }
    
    .layout-presentation.transition-throw .page.next {
        visibility: visible !important;
        -webkit-transform: none;
        transform: none;
        opacity: 1;
        z-index: 2;
    }
    
    /* Magazine Transition */
    .layout-magazine.transition-magazine>div>div {
        -webkit-transform-style: preserve-3d;
        transform-style: preserve-3d;
        -webkit-perspective: 3000px;
        perspective: 3000px;
    }
    
    .layout-magazine.transition-magazine .page {
        -webkit-transition: -webkit-transform 0.5s;
        transition: transform 0.5s;
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
    }
    
    :not(.isR2L).layout-magazine.transition-magazine .page:nth-child(odd),
    .isR2L.layout-magazine.transition-magazine .page:nth-child(even) {
        -webkit-transform-origin: left top 0;
        transform-origin: left top 0;
    }
    
    :not(.isR2L).layout-magazine.transition-magazine .page:nth-child(even),
    .isR2L.layout-magazine.transition-magazine .page:nth-child(odd) {
        -webkit-transform-origin: right top 0;
        transform-origin: right top 0;
    }
    
    .layout-magazine.transition-magazine .page.current,
    :not(.isR2L).layout-magazine.transition-magazine .page.prev:nth-child(even),
    :not(.isR2L).layout-magazine.transition-magazine .page.next:nth-child(odd),
    :not(.isR2L).layout-magazine.transition-magazine .page.before:nth-child(even),
    :not(.isR2L).layout-magazine.transition-magazine .page.after:nth-child(odd),
    .isR2L.layout-magazine.transition-magazine .page.next:nth-child(odd),
    .isR2L.layout-magazine.transition-magazine .page.prev:nth-child(even),
    .isR2L.layout-magazine.transition-magazine .page.after:nth-child(odd),
    .isR2L.layout-magazine.transition-magazine .page.before:nth-child(even) {
        -webkit-transform: none !important;
        transform: none !important;
    }
    
    :not(.isR2L).layout-magazine.transition-magazine .page.before:nth-child(odd),
    :not(.isR2L).layout-magazine.transition-magazine .page.prev:nth-child(odd),
    .isR2L.layout-magazine.transition-magazine .page.after:nth-child(even),
    .isR2L.layout-magazine.transition-magazine .page.next:nth-child(even) {
        -webkit-transform: rotateY(-180deg);
        transform: rotateY(-180deg);
        z-index: 3;
    }
    
    :not(.isR2L).layout-magazine.transition-magazine .page.after:nth-child(even),
    :not(.isR2L).layout-magazine.transition-magazine .page.next:nth-child(even),
    .isR2L.layout-magazine.transition-magazine .page.before:nth-child(odd),
    .isR2L.layout-magazine.transition-magazine .page.prev:nth-child(odd) {
        -webkit-transform: rotateY(180deg);
        transform: rotateY(180deg);
        z-index: 3;
    }
    
    .layout-magazine.transition-magazine .page.prev,
    .layout-magazine.transition-magazine .page.next {
        visibility: visible;
    }
    
    .layout-magazine.transition-magazine .page.current {
        z-index: 2;
    }
    
    </style><style type="text/css">body {
        margin: 0;
        padding: 0;
    }
    
    /* Viewer panel */
    #idrviewer {
        transition-timing-function: ease;
        transition-duration: 200ms;
        top: 0px;
        bottom: 0;
        left: 0;
        right: 0;
        position: absolute;
    }
    
    @media (min-width: 800px) {
        .sidebar-open #idrviewer {
            left: 350px;
        }
    }
    
    .light-theme #idrviewer {
        background: #fafafa none repeat scroll 0 0;
    }
    
    .dark-theme #idrviewer {
        background: #666 none repeat scroll 0 0;
    }
    
    .page {
        box-shadow: 1px 1px 4px rgba(120, 120, 120, 0.5);
    }
    
    /* Shared utilities */
    .is-mobile .mobile-hidden {
        display: none;
    }
    
    .hidden {
        display: none;
    }
    
    /* Menu bars */
    #controls {
        height: 44px;
        position: fixed;
        text-align: center;
        top: 0;
        left: 0;
        right: 0;
        display: flex;
        justify-content: space-between;
    }
    
    #controls>div {
        display: flex;
        align-self: center;
    }
    
    #controls-left {
        justify-content: start;
        padding-left: 5px;
    }
    
    #controls-center {
        justify-content: center;
    }
    
    #controls-right {
        justify-content: flex-end;
        padding-right: 5px;
    }
    
    #controls select {
        height: 25px;
    }
    
    .btn {
        border: 0 none;
        height: 30px;
        padding: 0;
        width: 30px;
        background-color: transparent;
        display: inline-block;
        margin: 0 5px 0;
        vertical-align: top;
        cursor: pointer;
    }
    
    .btn svg {
        filter: drop-shadow(0 0 1px #595959);
    }
    
    #pgCount {
        font-family: Arial, serif;
        font-size: 15px;
        margin-left: 5px;
    }
    
    #pgCount,
    .btn,
    #controls select {
        align-self: center;
        color: white;
        fill: currentColor;
    }
    
    #controls select {
        border-radius: 5px;
    }
    
    #btnSelect,
    #btnZoomOut,
    #btnView {
        margin-left: 20px;
    }
    
    #btnGo {
        width: 55px;
    }
    
    #btnView {
        width: 105px;
    }
    
    #btnZoom {
        width: 95px;
    }
    
    body:fullscreen .icon-fullscreen,
    body:not(:fullscreen) .icon-fullscreen-exit {
        display: none;
    }
    
    .light-theme .icon-theme-light,
    .dark-theme .icon-theme-dark {
        display: none;
    }
    
    #btnSideToggle,
    #btnBookmarks,
    #btnSearch,
    #btnSelect {
        padding: 2px;
    }
    
    #btnThemeToggle,
    #btnThumbnails,
    #btnMove {
        padding: 3px;
    }
    
    .light-theme .controls {
        background: #9eacba none repeat scroll 0 0;
        border-bottom: 1px solid #7b8793;
    }
    
    .dark-theme .controls {
        background: #444 none repeat scroll 0 0;
        border-bottom: 1px solid #000;
    }
    
    .light-theme #pgCount,
    .light-theme .btn {
        text-shadow: 0 0 1px #595959;
    }
    
    .dark-theme #pgCount {
        opacity: 0.8;
    }
    
    .dark-theme .btn {
        opacity: 0.7;
    }
    
    .light-theme .btn:hover {
        opacity: 0.6;
    }
    
    .dark-theme .btn:hover {
        opacity: 0.95;
    }
    
    .light-theme .btn.disabled {
        opacity: 0.4;
    }
    
    .dark-theme .btn.disabled {
        opacity: 0.2;
    }
    
    .light-theme #controls select {
        background-color: #9aa8b6;
        border: 1px solid #7b8793;
    }
    
    .dark-theme #controls select {
        background-color: #656565;
        border: 1px solid #000;
    }
    
    /* Sidebar */
    #sidebar {
        transition-timing-function: ease;
        transition-duration: 200ms;
        top: 45px;
        bottom: 0;
        position: absolute;
        overflow: hidden;
        z-index: 999;
        left: -350px;
        width: 350px;
    }
    
    .sidebar-open #sidebar {
        left: 0;
    }
    
    #sidebar-controls {
        height: 44px;
        display: flex;
        padding-left: 5px;
    }
    
    #sidebar-content {
        top: 45px;
        bottom: 0;
        left: 0;
        right: 0;
        position: absolute;
        background-color: #eee;
    }
    
    #sidebar-content>div {
        overflow-y: scroll;
        -webkit-overflow-scrolling: touch;
        height: 100%;
    }
    
    .light-theme #sidebar {
        border-right: 1px solid #7b8793;
    }
    
    .dark-theme #sidebar {
        border-right: 1px solid #000;
    }
    
    /* Thumbnails panel */
    .thumbnail {
        cursor: pointer;
        display: block;
        padding: 8px 0;
        margin: 0 auto;
        text-align: center;
    }
    
    .thumbnail img {
        max-width: 160px;
        max-height: 100%;
        border-radius: 5px;
        border: 1px solid #bbb;
    }
    
    .currentPageThumbnail,
    .thumbnail:hover {
        background-color: #ddd;
    }
    
    .currentPageThumbnail img,
    .thumbnail:hover img {
        border: 1px solid #999;
    }
    
    .spinner {
        border: 6px solid #bbb;
        border-top: 6px solid #3c9fe1;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        margin: 0 auto;
    }
    
    .spinning {
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
    
        100% {
            transform: rotate(360deg);
        }
    }
    
    /* Bookmarks panel */
    #bookmarks-panel .bookmark-container {
        padding: 0;
        margin: 5px 0;
        font-family: Arial, serif;
        font-size: 15px;
    }
    
    #bookmarks-panel .bookmark-container .bookmark-item {
        margin: 0 5px 0 20px;
        position: relative;
    }
    
    #bookmarks-panel .bookmark-container .bookmark-item.parent>.toggle {
        display: list-item;
        position: absolute;
        left: -18px;
        border-radius: 4px;
        /* To centre the list marker inside this element, as it has an unchangeable 6px right margin, we'll compensate by setting a 6px left padding in here */
        padding-left: 6px;
        width: fit-content;
        list-style-position: inside;
        list-style-type: disclosure-closed;
        /* Needed to align the marker vertically with the text */
        line-height: 1.7;
        cursor: pointer;
    }
    
    #bookmarks-panel .bookmark-container .bookmark-item.parent.open>.toggle {
        list-style-type: disclosure-open;
    }
    
    #bookmarks-panel .bookmark-container .bookmark-item.parent .bookmark-container {
        display: none;
    }
    
    #bookmarks-panel .bookmark-container .bookmark-item.parent.open>.bookmark-container {
        display: initial;
    }
    
    #bookmarks-panel .bookmark-container .bookmark-item a {
        border-radius: 4px;
        padding: 5px;
        display: list-item;
        list-style-type: none;
        color: #333;
        text-decoration: none;
        cursor: pointer;
    }
    
    #bookmarks-panel .bookmark-container .bookmark-item .toggle:hover,
    #bookmarks-panel .bookmark-container .bookmark-item a:hover {
        background-color: #ddd;
    }
    
    /* Search panel */
    #search-panel {
        font-family: Arial, sans-serif;
        font-size: 14px;
    }
    
    #search-panel * {
        color: #333;
    }
    
    #search-panel .searchOption *,
    #search-panel #searchResults,
    #search-panel #searchResults a {
        margin: 5px;
    }
    
    #search-panel .search-head-wrap {
        display: flex;
        flex-direction: column;
        position: sticky;
        top: 0;
        background-color: #eee;
    }
    
    #search-panel .search-head-wrap .search-input-wrap {
        display: flex;
        align-items: center;
        width: 288px;
        height: 30px;
        margin: 20px auto 10px;
        border-radius: 5px;
        border: 1px solid #666;
        color: black;
        background-color: white;
    }
    
    #search-panel .search-head-wrap .search-input-wrap #searchInput {
        display: block;
        flex-grow: 1;
        padding: 5px;
        min-width: 0;
        border: unset;
        background-color: unset;
    }
    
    #search-panel .search-head-wrap .search-input-wrap #searchInput:focus-visible {
        border: unset;
        outline: unset;
    }
    
    #search-panel .search-head-wrap .search-input-wrap .search-count {
        display: flex;
        flex-wrap: nowrap;
        flex-direction: row;
        margin-right: 5px;
        cursor: default;
        user-select: none;
        font-size: 15px;
    }
    
    #search-panel .search-head-wrap .search-input-wrap #searchNavWrap {
        display: contents;
        height: 100%;
    }
    
    #search-panel .search-head-wrap .search-input-wrap #searchNavWrap button {
        width: auto;
        height: 100%;
        padding: unset;
        background-color: unset;
        border: unset;
    }
    
    #search-panel .search-head-wrap .search-input-wrap #searchNavWrap button:hover {
        background-color: rgba(0, 0, 0, 0.2);
    }
    
    #search-panel .search-head-wrap .search-input-wrap #searchNavWrap button:disabled {
        cursor: default;
        fill: #666666;
        background-color: rgba(0, 0, 0, 0.1);
    }
    
    #search-panel .search-head-wrap .search-input-wrap #searchNavWrap button:disabled:hover {
        background-color: rgba(0, 0, 0, 0.1);
    }
    
    #search-panel .search-head-wrap .search-input-wrap #searchNavWrap button svg {
        width: auto;
        height: 100%;
        flex: none;
    }
    
    #search-panel .search-head-wrap .searchOption {
        margin: 0 20px;
        display: block;
    }
    
    #search-panel hr {
        margin: 18px 5px 0;
    }
    
    #search-panel .result {
        text-decoration: none;
        display: block;
        word-wrap: break-word;
    }
    
    #search-panel .result:hover {
        background-color: #ddd;
    }
    
    /* Print styles */
    @media print {
        #controls {
            display: none;
        }
    
        #idrviewer {
            overflow: visible;
        }
    
        .page {
            box-shadow: none;
        }
    
        .page:not([data-state="loaded"]) {
            display: none;
        }
    }
    
    </style>

</head>
<body class="light-theme">
    <div id="main">
        
        <div id="idrviewer">
        <?php 
        $query = "SELECT zw_pickups.*,zw_customers.company_name,zw_pickup_categories.title FROM zw_pickups
         LEFT JOIN zw_customers ON zw_pickups.client = zw_customers.id 
         LEFT JOIN zw_pickup_categories ON zw_pickups.category = zw_pickup_categories.id
         WHERE zw_pickups.po='$poid' AND zw_pickups.completed_status = 1";
	$result = mysqli_query($con, $query);
    
    	while ($row = mysqli_fetch_assoc($result)) {
    	$pickupsid = $row['id'];
    	$rowdata = $row;
    	
        ?>
        
            <?php include("1.php"); ?>
            <?php include("2.php"); ?>
            <?php include("recycling.php"); ?>
            <?php include("3.php"); ?>
            <?php include("4.php"); ?>
            <?php include("5.php"); ?>
        
    	<?php } ?> 
    	</div>  
    </div>
   
</body>
</html>
