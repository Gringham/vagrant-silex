
<a <?= $active == 'home'? 'class = "active"':'' ?> href="home">Home</a>
<a <?= $active == 'blog'? 'class = "active"':'' ?> href="blog">Blog</a>
<a <?= $active == 'new'? 'class = "active"':'' ?> href="new">New</a>


<h1>
    <?php $view['slots']->output('title', 'Default title') ?>
</h1>

<hr/>
    <?php $view['slots']->output('content', 'My content') ?>
<hr/>
