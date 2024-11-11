document.addEventListener('DOMContentLoaded', function() {

    document.body.addEventListener('click', function(e) {
      if (e.target.matches('.larg div h3')) {
        const span = e.target.querySelector('span');
        if (span) {
          span.classList.toggle('close');
        }
        const paragraph = e.target.nextElementSibling;
        if (paragraph) {
          const isHidden = paragraph.style.display === 'none' || !paragraph.style.display;
          paragraph.style.display = isHidden ? 'block' : 'none';
        }
      }
    });
  
  
    document.body.addEventListener('click', function(e) {
      if (e.target.matches('nav ul li a')) {
        const title = e.target.getAttribute('data-title');
        const titleElement = document.querySelector('.title h2');
        if (titleElement) {
          titleElement.textContent = title;
        }
      }
    });
  });
  



  
/*

  */






