<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Crossout Bargers</title>
<link href="/css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div id="wrapper">
        <header>
            <label>Faction:
                <select id="select-faction">
                    <option value="All">All</option>
                    <option value="Engineers">Engineers</option>
                    <option value="Lunatics">Lunatics</option>
                    <option value="Nomads">Nomads</option>
                    <option value="Scavanger">Scavanger</option>
                    <option value="Steppenwolfs">Steppenwolfs</option>
                    <option value="Dawn's Children">Dawn's Children</option>
                    <option value="Firestarters">Firestarters</option>
                </select>
            </label>
            <label>Workbench price:<input id="workbench-price" type="number" min="0"></label>
            <a href="/?Rares" style="margin-left:20px;color: hsla(43, 29%, 71%, 1)">JS View Rares</a>
            <a href="/" style="margin-left:20px;color: hsla(43, 29%, 71%, 1)">JS View Epics</a>
            <a href="/dashboard/rares" style="margin-left:20px;color: hsla(43, 29%, 71%, 1)">Dashboard Epics</a>
            <a href="/dashboard/epics" style="margin-left:20px;color: hsla(43, 29%, 71%, 1)">Dashboard Epics</a>
        </header>
        <main>
            <hr>
            <header>
                <div class="item">item name</div>
                <div class="workbench">workbench</div>
                <div class="resources">resources</div>
                <div class="rares">spare parts
                    <svg viewBox="0 0 2 2">
                        <polygon points="0,0 2,0 1,1.8" />
                    </svg></div>
                <div class="margin">margin
                    <svg viewBox="0 0 2 2">
                        <polygon points="0,0 2,0 1,1.8" />
                    </svg>
                </div>
                <div class="faction">faction</div>
            </header>
            <hr>
            <ul>
<!--
                <li>
                    <section class="item">Powerful radar-detector long name</section>
                    <section class="scale">
                        <div class="workbench" style="width: 40px"><span>20</span></div>
                        <div class="resources" style="width: 116px"><span>58</span></div>
                        <div class="rares" style="width: 278px"><span>139</span></div>
                        <div class="margin" style="width: 98px"><span>49</span><span class="formatSellPrice">250</span></div>
                        <div class="margin formatBuyPrice" style="left: 30px"><span>230</span></div>
                    </section>
                    <section class="faction" style="width: 40px">Firestarters</section>
                </li>
-->
            </ul>        
        </main>
    </div>
    <script src="/js/stats.js"></script>
</body>
</html>
