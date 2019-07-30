<!-- 会員用ナビバー -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="/index.php">ECClone</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="/index.php">ホーム<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/shop/shop_list.php">商品一覧</a>
      </li>
    </ul>
    <ul class="navbar-nav">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <!-- 会員としてログインしているか判定する -->
           <?php if(isset($_SESSION['member_login'])==false) { ?>
                  ようこそ、ゲスト様　
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="/shop/shop_cartlook.php">カートを見る</a>
                    <a class="dropdown-item" href="/member/member_login.php">会員ログイン</a>
                  </div>
          <?php } else { ?>
                  ようこそ <?php print $_SESSION['member_name']; ?> 様
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="/shop/shop_cartlook.php">カートを見る</a>
                    <a class="dropdown-item" href="/member/member_logout.php">ログアウト</a>
                  </div>
          <?php } ?>
      </li>
    </ul>
  </div>
</nav>