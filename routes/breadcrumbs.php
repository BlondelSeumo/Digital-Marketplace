<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push(translate('Home'), route('home'));
});

Breadcrumbs::for('premium', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(translate('Premium'), route('premium.index'));
});

Breadcrumbs::for('contact', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(translate('Contact US'), route('contact'));
});

Breadcrumbs::for('favorites', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(translate('Favorites'), route('favorites'));
});

Breadcrumbs::for('categories', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(translate('Categories'), route('categories.index'));
});

Breadcrumbs::for('categories.category', function (BreadcrumbTrail $trail, $category) {
    $trail->parent('categories');
    $trail->push($category->name, $category->getLink());
});

Breadcrumbs::for('categories.sub-category', function (BreadcrumbTrail $trail, $category, $subCategory) {
    $trail->parent('categories.category', $category);
    $trail->push($subCategory->name, $subCategory->getLink());
});

Breadcrumbs::for('items', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(translate('Items'), route('items.index'));
});

Breadcrumbs::for('items.view', function (BreadcrumbTrail $trail, $item) {
    $trail->parent('items');
    $trail->push($item->category->name, $item->category->getLink());
    if ($item->subCategory) {
        $trail->push($item->subCategory->name, $item->subCategory->getLink());
    }
    $trail->push($item->name, $item->getLink());
});

Breadcrumbs::for('items.reviews', function (BreadcrumbTrail $trail, $item) {
    $trail->parent('items.view', $item);
    $trail->push(translate('Reviews'), $item->getReviewsLink());
});

Breadcrumbs::for('items.reviews.review', function (BreadcrumbTrail $trail, $item, $review) {
    $trail->parent('items.reviews', $item);
    $trail->push($review->id, $review->getLink());
});

Breadcrumbs::for('items.comments', function (BreadcrumbTrail $trail, $item) {
    $trail->parent('items.view', $item);
    $trail->push(translate('Comments'), $item->getCommentsLink());
});

Breadcrumbs::for('items.comments.comment', function (BreadcrumbTrail $trail, $item, $comment) {
    $trail->parent('items.comments', $item);
    $trail->push($comment->id, $comment->getLink());
});

Breadcrumbs::for('items.changelogs', function (BreadcrumbTrail $trail, $item) {
    $trail->parent('items.view', $item);
    $trail->push(translate('Changelogs'), $item->getChangeLogsLink());
});

Breadcrumbs::for('items.support', function (BreadcrumbTrail $trail, $item) {
    $trail->parent('items.view', $item);
    $trail->push(translate('Support'), $item->getSupportLink());
});

Breadcrumbs::for('cart', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(translate('Cart'), route('cart.index'));
});

Breadcrumbs::for('checkout', function (BreadcrumbTrail $trail, $transaction) {
    $trail->parent('cart');
    $trail->push(translate('Checkout'), route('checkout.index', $transaction->id));
});

Breadcrumbs::for('page', function (BreadcrumbTrail $trail, $page) {
    $trail->parent('home');
    $trail->push($page->title, route('page', $page->slug));
});

Breadcrumbs::for('help', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(translate('Help Center'), route('help.index'));
});

Breadcrumbs::for('help_category', function (BreadcrumbTrail $trail, $helpCategory) {
    $trail->parent('help');
    $trail->push($helpCategory->name, $helpCategory->getLink());
});

Breadcrumbs::for('help_article', function (BreadcrumbTrail $trail, $helpArticle) {
    $trail->parent('help_category', $helpArticle->category);
    $trail->push($helpArticle->title, $helpArticle->getLInk());
});

Breadcrumbs::for('blog', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(translate('Blog'), route('blog.index'));
});

Breadcrumbs::for('blog_category', function (BreadcrumbTrail $trail, $blogCategory) {
    $trail->parent('blog');
    $trail->push($blogCategory->name, route('blog.category', $blogCategory->slug));
});

Breadcrumbs::for('blog_article', function (BreadcrumbTrail $trail, $blogArticle) {
    $trail->parent('blog_category', $blogArticle->category);
    $trail->push($blogArticle->title, $blogArticle->getLInk());
});

Breadcrumbs::for('user', function (BreadcrumbTrail $trail) {
    $trail->push(translate('User'), route('user.index'));
});

Breadcrumbs::for('user.purchases', function (BreadcrumbTrail $trail) {
    $trail->parent('user');
    $trail->push(translate('Purchases'), route('user.purchases.index'));
});

Breadcrumbs::for('user.transactions', function (BreadcrumbTrail $trail) {
    $trail->parent('user');
    $trail->push(translate('Transactions'), route('user.transactions.index'));
});

Breadcrumbs::for('user.transactions.show', function (BreadcrumbTrail $trail, $trx) {
    $trail->parent('user.transactions');
    $trail->push($trx->id, route('user.transactions.show', $trx->id));
});

Breadcrumbs::for('user.wallet.index', function (BreadcrumbTrail $trail) {
    $trail->parent('user');
    $trail->push(translate('My Wallet'), route('user.wallet.index'));
});

Breadcrumbs::for('user.refunds.index', function (BreadcrumbTrail $trail) {
    $trail->parent('user');
    $trail->push(translate('Refunds'), route('user.refunds.index'));
});

Breadcrumbs::for('user.refunds.create', function (BreadcrumbTrail $trail) {
    $trail->parent('user.refunds.index');
    $trail->push(translate('Request a Refund'), route('user.refunds.create'));
});

Breadcrumbs::for('user.refunds.show', function (BreadcrumbTrail $trail, $refund) {
    $trail->parent('user.refunds.index');
    $trail->push($refund->id, route('user.refunds.show', $refund->id));
});

Breadcrumbs::for('user.tickets.index', function (BreadcrumbTrail $trail) {
    $trail->parent('user');
    $trail->push(translate('Tickets'), route('user.tickets.index'));
});

Breadcrumbs::for('user.tickets.create', function (BreadcrumbTrail $trail) {
    $trail->parent('user.tickets.index');
    $trail->push(translate('New Ticket'), route('user.tickets.create'));
});

Breadcrumbs::for('user.tickets.show', function (BreadcrumbTrail $trail, $ticket) {
    $trail->parent('user.tickets.index');
    $trail->push($ticket->id, route('user.tickets.show', $ticket->id));
});

Breadcrumbs::for('user.settings', function (BreadcrumbTrail $trail) {
    $trail->parent('user');
    $trail->push(translate('Settings'), route('user.settings.index'));
});

Breadcrumbs::for('user.kyc', function (BreadcrumbTrail $trail) {
    $trail->parent('user');
    $trail->push(translate('KYC Verification'), route('user.kyc.index'));
});