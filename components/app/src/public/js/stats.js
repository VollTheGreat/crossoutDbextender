new Stats();

function Stats() {
    
    'use strict';
        
    var allStats;
    var itemsMargin;

    if(window.location.search.includes('Rares')){
        var url = '/api/rares/';
    }else{
        var url = '/api/epics/';
    }


    loadData(url);
    
    function loadData(url) {
        
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {

            if (this.readyState === 4 && this.status === 200) {
                allStats = JSON.parse(this.responseText);
                initWidgets();
            }

        };

        xhr.open('GET', url, true);
        xhr.send();
        
    }
    
    function initWidgets() {
        
        itemsMargin = new ItemsMargin();
        itemsMargin.sort('marginDescending');
        itemsMargin.replace();
        
    }
    
    function ItemsMargin() {
        
        var factionSelect = document.querySelector('#select-faction');

        var workbenchInput = document.querySelector('#workbench-price');
        var workbenchPrice = allStats.craftWorkBenchPrice;
        workbenchInput.value = workbenchPrice;
        var listDOMEL = document.querySelector('ul');
        var headerDOM = document.querySelector('main > header');
        var btnRares = headerDOM.querySelector('.rares');
        var btnMargin = headerDOM.querySelector('.margin');

        var itemsArray = Object.values(allStats.epicsData);
        calculate(itemsArray);
        initHeaderSorting();
        initFactionSelector();
        initWorkbenchInput();
        
        this.sort = sort;
        this.replace = replace;
        
        
        
        function sort(type) {

            itemsArray.sort(sorting);
            
            function sorting(a, b) {
                
                var c = Math.round(100 * (allStats.crafts[a.name])) / 100;
                var d = Math.round(100 * (allStats.crafts[b.name])) / 100;
                
                switch (type) {
                    case 'marginDescending':
                        btnRares.classList.remove('active');
                        btnRares.classList.remove('ascending');
                        btnMargin.classList.add('active');                    
                        btnMargin.classList.remove('ascending');                    
                        return d - c;
                        break;
                    case 'marginAscending':
                        btnRares.classList.remove('active');
                        btnRares.classList.remove('ascending');
                        btnMargin.classList.add('active');                    
                        btnMargin.classList.add('ascending');
                        return c - d;
                        break;
                    case 'raresDescending':
                        btnRares.classList.add('active');
                        btnRares.classList.remove('ascending');
                        btnMargin.classList.remove('active');                    
                        btnMargin.classList.remove('ascending');
                        return b.totalPrice - a.totalPrice;
                        break;
                    case 'raresAscending':
                        btnRares.classList.add('active');
                        btnRares.classList.add('ascending');
                        btnMargin.classList.remove('active');                    
                        btnMargin.classList.remove('ascending');
                        return a.totalPrice - b.totalPrice;
                        break;
                    default:
                        break;
                }
                
            }
            
        }
        
        function calculate(array) {

            array.forEach((item) => {
                item.primeCost = workbenchPrice + allStats.craftEpicRentalPrice + item.totalPrice;
                item.marginBuy = item.formatBuyPrice - item.primeCost;
                item.finalMargin = Math.round(100 * (allStats.crafts[item.name])) / 100;
                
            });
            
        }
        
        function replace() {
            
            listDOMEL.innerHTML = '';
            
            var list = '';
            
            for (let i = 0; i < itemsArray.length; i++) {
                
                let item = itemsArray[i];
                
                if (factionSelect.value === 'All') {
                    
                    generateLiDOM(item);
                    
                } else if (item.faction === factionSelect.value) {
                    
                    generateLiDOM(item);
                    
                }

            }
                
            listDOMEL.innerHTML = list;
            
            
            function generateLiDOM(item) {
                
                var bgColor = 'hsla(283, 100%, 75%, 1)';
                var transform = '0';

                if (item.finalMargin < 0) {

                    bgColor = 'hsla(283,50%,50%,0.65)';
                    transform = '-100';

                }

                if(item.rarityName === "Rare"){
                    var number = 20 ;
                } else {
                    var number = 1.5;
                }



                var listItem =  '<li><section class="item">' + item.name + '</section>' +
                                '<section class="scale">' +
                                    '<div class="workbench" style="width: ' + workbenchPrice * number + 'px"><span>' + workbenchPrice + '</span></div>' +
                                    '<div class="resources" style="width: ' + allStats.craftEpicRentalPrice * number + 'px"><span>' + allStats.craftEpicRentalPrice + '</span></div>' +
                                    '<div class="rares" style="width: ' + item.totalPrice * number + 'px"><span>' + item.totalPrice + '</span></div>' +
                                    '<div class="margin" style="width: ' + Math.abs(item.finalMargin) * number + 'px; background-color: ' + bgColor + '; transform: translateX(' + transform + '%)"><span>' + item.finalMargin + '</span><span class="formatSellPrice">' + item.formatSellPrice + '</span></div>' +
                                '</section>' +
                                '<section class="faction">' + item.faction + '</section></li>';

                list += listItem;
                
            }
            
            
        }
        
        function initHeaderSorting() {
            
            btnRares.onclick = btnMargin.onclick = function() {
                
                let prefix = this.classList.item(0);
                
                if (this.classList.contains('active')) {
                    
                    if (this.classList.contains('ascending')) {
                        sort(prefix + 'Descending');
                    } else {
                        sort(prefix + 'Ascending');
                    }
                    
                } else {
                    
                    sort(prefix + 'Descending');
                    
                }
                
                replace();
                
            }
        
        }
        
        function initFactionSelector() {
            
            factionSelect.onchange = replace;
            
        }
        
        function initWorkbenchInput() {
            
            workbenchInput.onchange = function() {
                
                calculate(itemsArray);
                replace();
                
            }
            
        }
        
    }
    
}