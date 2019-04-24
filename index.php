<!DOCTYPE html>
<html lang="zh-Hant-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/all.min.css">
    <title>我的待辦事項 - My TodoList</title>
</head>
<body>
  <div class="container my-3">
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <label class="input-group-text" for="typingTask">待辦事項</label>
      </div>
      <input type="text" class="form-control" placeholder="Do something..." id="typingTask">
      <div class="input-group-append">
        <button class="btn btn-primary" type="button" id="addTask">新增</button>
      </div>
    </div>
    <div class="card text-center">
      <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
          <li class="nav-item">
            <a class="nav-link active" href="#" id="allFilter">全部(0)</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="#" id="doingFilter">進行中(0)</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" id="completeFilter">已完成(0)</a>
          </li>
        </ul>
      </div>
      <ul class="list-group list-group-flush text-left" id="taskList">
      </ul>
      <div class="card-footer d-flex justify-content-between">
        <span id="uncomplete">還有 0 筆任務未完成</span>
        <a href="#" id="clearAll">清除所有任務</a>
      </div>
    </div>
  </div>
  <script src="./javascript/jquery-3.3.1.min.js"></script>
  <script src="./javascript/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
  <script src="./javascript/all.js"></script>
</body>
</html> 