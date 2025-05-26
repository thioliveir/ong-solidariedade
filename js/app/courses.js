// Selecionar os elementos do formulário
const form = document.getElementById("formCursos")
const inputName = document.getElementById("nome")
const inputModality = document.getElementById("modalidade")
const inputloadHourly = document.getElementById("carga_horaria")
const inputStartDate = document.getElementById("data_inicio")
const inputEndDate = document.getElementById("data_fim")
const inputQtdStudents = document.getElementById("qtd_max_alunos")
const inputSituation = document.getElementById("status")
const inputDescription = document.getElementById("descricao")
const inputTurnoManha = document.getElementById("turno-manha")
const inputTurnoTarde = document.getElementById("turno-tarde")
const inputTurnoNoite = document.getElementById("turno-noite")

// Variável para armazenar o ID do curso a ser excluido
let idCourseExcluir = null

// Função carregar os cursos na tabela
async function loadCourses() {
    try {
        const response = await fetch("../../ong_solidariedade/controllers/listar_curso.php")
        const courses = await response.json()


        const tableCoursesBody = document.querySelector("#tabelaCursos tbody")
        tableCoursesBody.innerHTML = ""

        courses.forEach((course => {
            const tr = document.createElement("tr")
            
            tr.innerHTML = `
                <td>${course.nome}</td>
                <td class="text-truncate">${course.modalidade}</td>
                <td>${course.carga_horaria}</td>
                <td>${course.turnos}</td>
                <td>${course.status}</td>
                <td>
                    <button class="btn btn-sm btn-info btn-detalhar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-btn" data-id="${course.id}" data-bs-title="Detalhes">
                        <i class="bi bi-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-warning btn-editar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-btn" data-id="${course.id}" data-bs-title="Editar">
                        <i class="bi bi-pen"></i>
                    </button>
                    <button class="btn btn-sm btn-danger btn-excluir" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-btn" data-id="${course.id}" data-bs-title="Excluir">
                        <i class="bi bi-trash3"></i>
                    </button>
                </td>
            `
            tableCoursesBody.appendChild(tr)
        }))
        // Reaplica tooltip
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltipTriggerList.forEach(el => new bootstrap.Tooltip(el))

        
    } catch (error) {
        console.error("Erro ao carregar os cursos:", error)
    }
}

//Função carregar modal e dataTable e input carga horária
document.addEventListener("DOMContentLoaded", async () => {
    // Carregar o modal
    window.modalInstance = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalCursos'))
    // Carregar os cursos na tabela
    await loadCourses()
    // Carregar o dataTable
    $('#tabelaCursos').DataTable()
    // Carregar o input de carga horária
    const loadHourlyInput = document.getElementById("carga_horaria")
    loadHourlyInput.addEventListener("input", function() {
        const min = 8
        const max = 7200
        const value = parseInt(this.value)

        if(value < min) {
            this.value = min
        } else if(value > max) {
            this.value = max
        }
    })
    // Tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl);
    });


})

// Função para receber o nome do curso e formatá-lo
function capitalizeName(name) {
    return name.charAt(0).toUpperCase() + name.slice(1).toLowerCase()
}
// Função para validar o formulário
function validateForm() {
    const name = inputName.value.trim()
    const modality = inputModality.value.trim()
    const loadHourly = inputloadHourly.value.trim()
    const startDate = inputStartDate.value.trim()
    const endDate = inputEndDate.value.trim()
    const qtdStudents = inputQtdStudents.value.trim()
    const situation = inputSituation.value.trim()
    const description = inputDescription.value.trim()

    if (name === "" || modality === "" || loadHourly === "" || startDate === "" || endDate === "" || qtdStudents === "" || situation === "" || description === "") {
        alert("Por favor, preencha todos os campos obrigatórios.")
        return false
    }
    return true
}

// Função para enviar o formulário
formCursos.addEventListener("submit", async function(event) {
    event.preventDefault()

    const idEdit = document.getElementById("inputIdCurso")?.value

    if(!validateForm()) {
        return
    }
    const checkBoxes = document.querySelectorAll('input[name="turno[]"]')
    const checkedValues = Array.from(checkBoxes).some(checkbox => checkbox.checked)
    if(!checkedValues) {
        alert("Por favor, selecione pelo menos um turno.")
        return
    }
    const turnosSelected = []
    document.querySelectorAll('input[name="turno[]"]:checked').forEach((checkbox) => {
        turnosSelected.push(checkbox.value)
    })
    if (new Date(inputEndDate.value) < new Date(inputStartDate.value)) {
        alert("A data de término não pode ser anterior à data de início.");
        return;
    }

    const newCourse = {
        nome: capitalizeName(inputName.value),
        modalidade: inputModality.value,
        carga_horaria: inputloadHourly.value,
        data_inicio: inputStartDate.value,
        data_fim: inputEndDate.value,
        qtd_max_alunos: inputQtdStudents.value,
        status: inputSituation.value,
        descricao: inputDescription.value,
        turno: turnosSelected,
    }

    const formData = new FormData()
    for (const key in newCourse) {
        if(Array.isArray(newCourse[key])) {
            newCourse[key].forEach((value) => {
                formData.append(key + "[]", value)
            })
        } else {
            formData.append(key, newCourse[key])
        }
    }

    if (idEdit) {
        formData.append("id", idEdit)
    }

    try {
        const alertSuccess = document.getElementById("alert-success")
        const alertDanger = document.getElementById("alert-danger")

        const url = idEdit ?
         "../../ong_solidariedade/controllers/editar_curso.php" :
          "../../ong_solidariedade/controllers/salvar_curso.php"


        const response = await fetch(url, {
            method: "POST",
            body: formData
        })

        const data = await response.json()
        

        if(data.success) {
            //Fecha modal
            const modal = bootstrap.Modal.getInstance(document.getElementById("modalCursos"))
            if (modal) {
                document.activeElement.blur();
                modal.hide()
            }
            //Exibe alerta de Sucesso
            const successMensage = document.getElementById("successMensage")
            if(idEdit) {
                successMensage.textContent = "Curso editado com sucesso!"
            } else {
                successMensage.textContent = "Curso cadastrado com sucesso!"
            }
            alertSuccess.style.display = "flex"
            alertSuccess.classList.add("show")

            formCursos.reset()
            const inputIdCurso = document.getElementById("inputIdCurso")
            if (inputIdCurso) {
                inputIdCurso.value = ""
            }
            // Destrói o DataTable antes de recarregar os dados
            if ($.fn.DataTable.isDataTable('#tabelaCursos')) {
                $('#tabelaCursos').DataTable().destroy()
            }
            //Recarrega a tabela
            await loadCourses()
            //Reinicia o DataTable
            $('#tabelaCursos').DataTable()
        } else {
            const modal = bootstrap.Modal.getInstance(document.getElementById("modalCursos"))
            if (modal) {
                document.activeElement.blur();
                modal.hide()
            }
            //Exibe alerta de Erro
            const errorMessage = document.getElementById("dangerMensage")
            errorMessage.textContent = data.message || "Erro ao cadastrar o curso."
            alertDanger.style.display = "flex"
            alertDanger.classList.add("show")
        }
        
    } catch (error) {
        console.error("Error:", error)
        alert("Erro ao enviar o formulário. Tente novamente mais tarde.")
    }
})

// Visualizar e editar os dados do curso
document.querySelector("#tabelaCursos").addEventListener("click", async (e) => {
    
    const btnDetails = e.target.closest(".btn-detalhar")
    const btnEdit = e.target.closest(".btn-editar")
    const btnExcluir = e.target.closest(".btn-excluir")

    // Visualizar os dados do curso
    if(btnDetails) {
        const id = btnDetails.getAttribute("data-id")
        visualizarCurso(id)
    }

    // Editar os dados do curso
    if(btnEdit) {
        const idEdit = btnEdit.getAttribute("data-id")
        editarCurso(idEdit)
    }
    // Excluir os dados do curso
    if(btnExcluir) {
        idCourseExcluir = btnExcluir.getAttribute("data-id")
        const modalEl = document.getElementById("modalConfirmarExclusao")
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl)
        modal.show()
    }
    
})

// Função para visualizar os dados do curso
async function visualizarCurso(id) {
    try {
        const response = await fetch(`../../ong_solidariedade/controllers/detalhar_curso.php?id=${id}`)
        const data = await response.json()
        if (!data.success) {
            throw new Error(data.message || "Erro ao carregar os detalhes do curso.")
        }

        const curso = data.curso

        // Preencher os campos do modal com os dados do curso (modo somente leitura)
        document.getElementById("modalCursosLabel").innerText = "Detalhes do Curso";
        inputName.value = curso.nome
        inputModality.value = curso.modalidade
        inputloadHourly.value = curso.carga_horaria
        inputStartDate.value = curso.data_inicio
        inputEndDate.value = curso.data_fim
        inputQtdStudents.value = curso.qtd_max_alunos
        inputSituation.value = curso.status
        inputDescription.value = curso.descricao

        // Resetar os checkboxes
        document.querySelectorAll('input[name="turno[]"]').forEach((checkbox) => {
            checkbox.checked = false
        })

        curso.turno.forEach((turnoNome) => {
            const idCheckbox = `turno-${turnoNome.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase()}`
            const checkbox = document.getElementById(idCheckbox)
            if(checkbox) {
                checkbox.checked = true
            }
        })
        // Desabilitar os campos (modo somente leitura)
        const fields = document.querySelectorAll("#formCursos input, #formCursos select, #formCursos textarea");
        fields.forEach(field => field.setAttribute("disabled", "disabled"));

        // Ocultar botão de salvar
        document.getElementById("btnSubmit").style.display = "none";

        const modal = new bootstrap.Modal(document.getElementById("modalCursos"))
        modal.show()
        
    } catch (error) {
        console.error(error);
        alert("Erro ao visualizar curso.");
    }
}

// Editar os dados do curso
async function editarCurso(id) {
    try {
        const response = await fetch(`../../ong_solidariedade/controllers/detalhar_curso.php?id=${id}`)
        const data = await response.json()

        if (!data.success) {
            alert("Erro ao buscar curso: " + data.error)
            return
        }

        const curso = data.curso

        // Preencher os campos do modal com os dados do curso
        inputName.value = curso.nome
        inputModality.value = curso.modalidade
        inputloadHourly.value = curso.carga_horaria
        inputStartDate.value = curso.data_inicio
        inputEndDate.value = curso.data_fim
        inputQtdStudents.value = curso.qtd_max_alunos
        inputSituation.value = curso.status
        inputDescription.value = curso.descricao

        // Marcar apenas os que vieram no retorno
        curso.turno.forEach(turno => {
            const checkbox = document.querySelector(`#formCursos input[name='turno[]'][value='${turno}']`);
            if (checkbox) {
                checkbox.checked = true;
            }
        })

        document.querySelector("#modalCursos #modalCursosLabel").textContent = "Editar Curso"

        document.getElementById("inputIdCurso").value = curso.id

        const modal = new bootstrap.Modal(document.getElementById("modalCursos"))
        modal.show()

    } catch (error) {
        console.error("Erro ao carregar os detalhes do curso:", error)
        alert("Erro ao carregar os detalhes do curso.")
    }
}
// Função para excluir o curso
async function excluirCurso() {
    if(!idCourseExcluir) return

    try {
        const formData = new FormData()
        formData.append("id", idCourseExcluir)

        const response = await fetch("../../ong_solidariedade/controllers/excluir_curso.php", {
            method: "POST",
            body: formData
        })

        const data = await response.json()

        if(data.success) {
            const modalEl = document.getElementById("modalConfirmarExclusao")
            const modal = bootstrap.Modal.getInstance(modalEl);
            document.activeElement.blur();
            modal.hide();

            // Mostrar alerta customizado
            const successAlert = document.getElementById("alert-success")
            const successMessage = document.getElementById("successMensage")

            successMessage.textContent = "Curso excluído"
            successAlert.classList.add("show")
            successAlert.classList.remove("fade")

            setTimeout(() => {
                successAlert.classList.remove("show")
                successAlert.classList.add("fade")
            }, 3000)

            if($.fn.DataTable.isDataTable('#tabelaCursos')) {
                $('#tabelaCursos').DataTable().destroy()
            }
            await loadCourses()
            $('#tabelaCursos').DataTable()
        } else {
            const modalEl = document.getElementById("modalConfirmarExclusao")
            const modal = bootstrap.Modal.getInstance(modalEl);
            document.activeElement.blur();
            modal.hide();

            alert("Erro ao excluir curso: " + data.message)
        }
    } catch (error) {
        console.error("Erro ao excluir curso:", error)
        alert("Erro na requisição.")
    } finally {
        idCourseExcluir = null
    }
}
// Chamar o modal de confirmação de exclusão
document.querySelector("#btnConfirmarExclusao").addEventListener("click", async () => {
    if (!idCourseExcluir) return;
    await excluirCurso(idCourseExcluir);
});


// Retorna o modal ao estado inicial
document.getElementById("modalCursos").addEventListener("hidden.bs.modal", () => {
    [...document.querySelectorAll("#formCursos input, #formCursos select, #formCursos textarea")].forEach(el => {
        el.readOnly = false
        el.disabled = false
    })

    document.getElementById("btnSubmit").style.display = "inline-block"
    document.querySelector("#modalCursos #modalCursosLabel").textContent = "Cadastrar Curso"
    document.getElementById('formCursos').reset();
})