$(document).ready(() => {
    const $menuButton = $('.submit2');
    const $navDropdown = $('.one');
    $menuButton.on('click',()=>{
      $navDropdown.hide();
      $('.book-con').fadeIn(900);
    });
    
  
  
  });