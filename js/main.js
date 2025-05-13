// POPOVER CARDS
let currentPopover = null

const cards = [
    {
        id: "#card1",
        title: "Curso de Informática Básica",
        content: `<p>Aprenda os principais recursos do computador, como digitação, uso de programas do Office (Word, Excel, PowerPoint) e navegação segura na internet. Ideal para quem está começando e quer dar o primeiro passo na inclusão digital.</p>
                <button class='btn btn-sm btn-danger mt-2' onclick='fecharPopover()'>Fechar</button>`
    },
    {
        id: "#card2",
        title: "Programa de Empregabilidade",
        content: `<p>Capacitação prática voltada para o mercado de trabalho. Inclui elaboração de currículo, simulação de entrevistas, desenvolvimento de habilidades comportamentais (soft skills) e acesso a oportunidades com empresas parceiras.</p>
                <button class='btn btn-sm btn-danger mt-2' onclick='fecharPopover()'>Fechar</button>`
    },
    {
        id: "#card3",
        title: "Curso de Marketing Digital",
        content: `<p>Descubra como usar as redes sociais, ferramentas de anúncio e estratégias de conteúdo para promover produtos, serviços ou sua própria marca. Um curso essencial para quem quer empreender ou trabalhar com comunicação online.</p>
                <button class='btn btn-sm btn-danger mt-2' onclick='fecharPopover()'>Fechar</button>`
    },
]

cards.forEach(({ id, title, content }) => {
    const el = document.querySelector(id)

    const popover = new bootstrap.Popover(el, {
        title: title,
        content: content,
        html: true,
        trigger: "manual",
        placement: "right",
        sanitize: false
    })

    el.addEventListener("mouseenter", function () {
        if (currentPopover && currentPopover !== popover) {
            currentPopover.hide()
        }
        popover.show()
        currentPopover = popover
    })
})

window.fecharPopover = function () {
    if (currentPopover) {
        currentPopover.hide()
        currentPopover = null
    }
}


// Testimonials cards carousel slider
const itemCarouselCard = document.querySelector("#carouselTestimonials");

if (window.matchMedia("(min-width:576px)").matches) {
  const carousel = new bootstrap.Carousel(itemCarouselCard, {
    interval: false,
    ride: false,
    wrap: false
  });

  const carouselInner = itemCarouselCard.querySelector(".carousel-inner");
  const cards = itemCarouselCard.querySelectorAll(".carousel-item");
  const nextBtn = itemCarouselCard.querySelector(".carousel-control-next");
  const prevBtn = itemCarouselCard.querySelector(".carousel-control-prev");
  const indicators = itemCarouselCard.querySelectorAll(".carousel-indicators button");

  const cardWidth = cards[0].offsetWidth;
  const totalWidth = carouselInner.scrollWidth;
  const visibleCards = Math.floor(carouselInner.offsetWidth / cardWidth);

  let scrollPosition = 0;
  let activeIndex = 0;

  // Atualiza os botões de navegação
  function updateButtons() {
    if (scrollPosition <= 0) {
      prevBtn.style.display = "none";
    } else {
      prevBtn.style.display = "flex";
    }

    if (scrollPosition >= totalWidth - carouselInner.offsetWidth) {
      nextBtn.style.display = "none";
    } else {
      nextBtn.style.display = "flex";
    }

    updateIndicators();
  }

  // Atualiza os indicadores de acordo com o índice ativo
  function updateIndicators() {
    indicators.forEach((indicator, index) => {
      if (index === activeIndex) {
        indicator.classList.add('active');
      } else {
        indicator.classList.remove('active');
      }
    });
  }

  // Mover o carousel para a próxima seção (de 3 em 3 cards)
  nextBtn.addEventListener("click", () => {
    if (scrollPosition < totalWidth - carouselInner.offsetWidth) {
      scrollPosition += cardWidth * 3; // Avança 3 cards
      carouselInner.scrollTo({ left: scrollPosition, behavior: "smooth" });

      activeIndex = Math.floor(scrollPosition / cardWidth);
      updateButtons();
    }
  });

  // Mover o carousel para a seção anterior (de 3 em 3 cards)
  prevBtn.addEventListener("click", () => {
    if (scrollPosition > 0) {
      scrollPosition -= cardWidth * 3; // Retrocede 3 cards
      carouselInner.scrollTo({ left: scrollPosition, behavior: "smooth" });

      activeIndex = Math.floor(scrollPosition / cardWidth);
      updateButtons();
    }
  });

  // Atualiza o índice ativo ao clicar nos indicadores
  indicators.forEach((indicator, index) => {
    indicator.addEventListener('click', () => {
      activeIndex = index;
      scrollPosition = index * cardWidth;
      carouselInner.scrollTo({ left: scrollPosition, behavior: "smooth" });
      updateButtons();
    });
  });

  updateButtons();

} else {
  itemCarouselCard.classList.add("slide");
}

// Botão de voltar ao topo
const backToTopBtn = document.getElementById("scrollTopBtn");
const footer = document.getElementById("footer-infos");

function scrollToTop() {
  window.scrollTo({ top: 0, behavior: "smooth" })
}

function handleScroll() {
  const scrollY = window.scrollY
  const footerTop = footer.getBoundingClientRect().top + window.scrollY
  const windowHeight = window.innerHeight

  const reachedFooter = scrollY + windowHeight >= footerTop

  if(scrollY > 300 && !reachedFooter) {
    backToTopBtn.style.display = "block"
  } else {
    backToTopBtn.style.display = "none"
  }
}

window.addEventListener("scroll", handleScroll)
backToTopBtn.addEventListener("click", scrollToTop);





