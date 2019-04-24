$(document).ready(function () {
  // 取得資料
  getTask();
  // 先 focus 在輸入欄
  $('#typingTask').focus();
  // tab切換
  $('.nav-item a').on('click', function(e){
    e.preventDefault();
    $('.nav-item a').removeClass('active');
    $(this).addClass('active');
    taskfilter($(this).attr('id'));
  });
  // 點擊按鈕新增Task
  $('#addTask').on('click', function(e){
    if (!$('#typingTask').val()){ return }
    addTask();
  });
  // 偵測鍵盤新增Task
  $('#typingTask').on('keydown', function(e){
    if (e.which === 13){
      if (!$('#typingTask').val()){ return }
      addTask();
    }
  });
  // 刪除所有 Task
  $('#clearAll').on('click', function(e){
    e.preventDefault();
    let doubleCheck = confirm("是否真的要刪除全部的任務(包含未完成、已完成)，此步驟無法復原！");
    if (doubleCheck){
      $.post(`todo/delete.php`, function (data) {
        getTask();
      });
    }
  });

  $('#taskList')
    // 雙擊編輯
    .on('dblclick', '.list-group-item', function(e){
      if(e.target.nodeName === 'INPUT' || e.target.nodeName === 'LABEL') { return };
      const self = $(this);
      const originEl = self.children();
      const originText = self.find('label').text();
      // 編輯Input
      let innerEl = `<input type="text" class="form-control" id="editText">`;
      self.html(innerEl).find('#editText').val(originText).focus();
      // editText 按鍵偵測
      $('#editText').on('keydown', function(e){
        if (e.which === 27){
          // 按下 ESC 離開
          self.html(originEl);
        }
        if (e.which === 13){
          // 按下 enter 修改
          let newText = $('#editText').val();
          let updateObj = {
            content: newText,
            id: self.data("id")
          }
          $.post("todo/update.php", updateObj);
          self.html(originEl).find('label').text(newText);   
        }
      });
      // 離焦時離開
      $('#editText').on('blur', function(){
        self.html(originEl);
      });
    })
    // 點擊 X 刪除 Task
    .on('click', '.close', function(){
      let self = $(this);
      let delContent = $(this).siblings('.form-check').find('label').text();
      let doubleCheck = confirm(`是否真的要刪除該任務「${delContent}」，此步驟無法復原！`);
      let id = $(this).closest('li').data("id");
      if (doubleCheck){ 
        $.post(`todo/delete.php?${id}`, {id: id}, function (data) {
          self.closest("li").remove();
          countTask();
        });
      }
    })
    // complete 狀態切換
    .on('click', '.form-check-input', function(e){
      let self = $(this);
      let id = self.closest("li").data("id");
      $.post(`todo/compelete.php`, { id: id }, function (data) {
        self.closest('li').toggleClass('complete');
        countTask();
        taskfilter($('.nav-tabs').find('.active').attr('id'));
      });
    })
    // 排序
    .sortable({
      stop: function( event, ui ) {
        let orderArray = [];
        $('#taskList').find('li').each(function(index, li){
          console.log(index, li);
          orderArray.push({
            id: $(li).data('id'),
            newOrder: index + 1
          });
        });
        $.post(`todo/sort.php`, { orderArray: orderArray });
      }
    });

  function addTask(){
    // 輸入的資料
    const typingText = $('#typingTask').val().replace(/[<|>|/|<|\s]/g,"").trim();
    let taskObj = {
      content: typingText,
      order: $('#taskList li').length + 1
    }
    $('#typingTask').attr("disabled","disabled");
    $('#addTask').attr("disabled","disabled");
    // AJAX 進入點
    $.post("todo/create.php", taskObj, function (data) {
      // 執行成功，更新畫面
      getTask();
      // 清除輸入
      $('#typingTask').val('');
    });
  }
  function countTask(){
    const allTask = $('#taskList li').length;
    const complete = $('#taskList').find('.complete').length;
    $('#allFilter').text(`全部(${allTask})`);
    $('#doingFilter').text(`進行中(${allTask - complete})`);
    $('#completeFilter').text(`已完成(${complete})`);
    $('#uncomplete').text(`還有 ${allTask - complete} 筆任務未完成`);
  }
  function taskfilter(id){
    switch (id) {
      case 'allFilter':
        // 全部
        $('#taskList li').show();
      break;
      case 'doingFilter':
        // 進行中
        $('#taskList li').show();
        $('#taskList').find('.complete').hide();
      break;
      case 'completeFilter':
        // 已完成
        $('#taskList li').hide();
        $('#taskList').find('.complete').show();
      break;
    }
  }
  function getTask(){
    $.get("todo/getAll.php", function (data) {
      $('#typingTask').attr("disabled", null);
      $('#addTask').attr("disabled", null);
      let taskArray = data;
      let htmlStr = '';
      taskArray.forEach(item => {
        let ischeck = '';
        let iscomplete = '';
        if (item.isCompelete === 1){
          ischeck = 'checked';
          iscomplete = 'complete';
        }
        let str = `
        <li class="list-group-item ${iscomplete}" data-id="${item.id}">
        <div class="d-flex">
          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="${item.id}" ${ischeck}>
            <label class="form-check-label" for="${item.id}">${item.content}</label>
          </div>
        <button type="button" class="close ml-auto" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>
      </li>`;
      htmlStr = htmlStr + str;
      });
      $('#taskList').html(htmlStr);
      // 計算資料筆數
      countTask();
      $('#typingTask').focus();
    });
  }
});