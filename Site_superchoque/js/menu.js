function showMenu(){
  //  alert('quica ni mim');
    const menulateral= DocumentTimeline.getElementbyId('menu-lateral')
    const iconMenu= DocumentTimeline.getElementbyId('img-menu')

menulateral.classList.toggle('ativa');


if (menulateral.classList.contains('ativa')){
    iconMenu.src = 'img/icon-close-menu.png';
}
else{
    iconMenu.src='img/icon-hamburguer-menu.png';
}

}