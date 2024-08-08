function showTab(tabId) {
    // 取得所有具有 class 'tab-button' 的元素
    var tabs = document.getElementsByClassName('tab-button');

    // 將所有 tab 的 'active' class 移除
    for (var i = 0; i < tabs.length; i++) {
        tabs[i].classList.remove('active');
    }

    // 在指定 id 的元素上添加 'active' class
    document.getElementById(tabId).classList.add('active');
}