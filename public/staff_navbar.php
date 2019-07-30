<!-- サイト管理者用ナビバー -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="/index.php">ECClone</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="/staff_login/staff_top.php">ショップ管理トップ<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/staff/staff_list.php">スタッフ管理</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/product/pro_list.php">商品管理</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/order/order_download.php">注文データ管理</a>
      </li>
    </ul>
    <ul class="navbar-nav">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php print $_SESSION['staff_name']; ?> さんログイン中
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="/staff_login/staff_logout.php">ログアウト</a>
        </div>
      </li>
    </ul>
  </div>
</nav>