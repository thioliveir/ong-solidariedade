
// Formulário de Registro
// Selecionar os elementos do formulário
const formAluno = document.getElementById("formAluno")
const nameStudents = document.getElementById("nameStudents")
const cpf = document.getElementById("cpf")
const birth = document.getElementById("birth")
const phone = document.getElementById("phone")
const course = document.getElementById("course")
const situation = document.getElementById("situation")
const sex = document.getElementById("sex")
const cep = document.getElementById("cep")
const address = document.getElementById("address")
const addressNumber = document.getElementById("number")
const complemento = document.getElementById("complemento")
const neighborhood = document.getElementById("neighborhood")
const city = document.getElementById("city")
const state = document.getElementById("state")

// Variável para armazenar a matrícula do aluno a ser excluído
let matriculaExcluir = null

// Carregar os alunos na tabela
async function carregarAlunos() {
    try {
        const response = await fetch("../../ong_solidariedade/controllers/consulta_aluno.php")
        const alunos = await response.json()

        const tableStudents = document.querySelector("#tabelaAlunos tbody")
        tableStudents.innerHTML = ""

        alunos.forEach(aluno => {
            const tr = document.createElement("tr")
            const dateFormatted = new Date(aluno.dataInclusao).toLocaleDateString("pt-BR")

            tr.innerHTML = `
                <td>${dateFormatted}</td>
                <td class="text-truncate">${aluno.name}</td>
                <td>${aluno.course}</td>
                <td>${aluno.matricula}</td>
                <td>${aluno.situation}</td>
                <td>
                    <button class="btn btn-sm btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-btn" data-matricula="${aluno.matricula}" data-bs-title="Detalhes" id="btnDetalhes">
                        <i class="bi bi-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-btn" data-matricula="${aluno.matricula}" data-bs-title="Editar" id="btnEditar">
                        <i class="bi bi-pen"></i>
                    </button>
                    <button class="btn btn-sm btn-danger btnExcluir" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-btn" data-matricula="${aluno.matricula}" data-bs-title="Excluir">
                        <i class="bi bi-trash3"></i>
                    </button>
                </td>
            `
            tableStudents.appendChild(tr)

        })
        // Reaplica tooltip
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltipTriggerList.forEach(el => new bootstrap.Tooltip(el));
    } catch (error) {
        
    }
}

//Carregamentos do Modal e do DataTable
document.addEventListener("DOMContentLoaded", async function () {
    window.modalInstance = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalAluno'))
    await carregarAlunos()
    $('#tabelaAlunos').DataTable()

    // Modal confrmação de exclusão
    document.addEventListener("click", function(e) {
        const btn = e.target.closest(".btnExcluir")
        if(btn) {
            matriculaExcluir = btn.getAttribute("data-matricula")

            console.log("matriculaExcluir setada como:", matriculaExcluir)

            const modal = new bootstrap.Modal(document.getElementById("modalConfirmarExclusao"))
            modal.show()
        }

        /*
        if(e.target && e.target.closest(".btnExcluir")) {
            matriculaExcluir = e.target.getAttribute("data-matricula")

            const modal = new bootstrap.Modal(document.getElementById("modalConfirmarExclusao"))
            modal.show()
        }
            */
    })
    // Função para confirmar a exclusão do aluno
    document.getElementById("btnConfirmarExclusao")
        .addEventListener("click", excluirAluno);
})

// Função para receber o nome do aluno e formatá-lo
function capitalizeName(name) {
    return name
        .toLowerCase()
        .split(" ")
        .map(word => word.charAt(0).toUpperCase() + word.slice(1))
        .join(" ")
}

//InputMask e CEP automatico
$(document).ready(function(){
    //InputMask
    $("#cpf").inputmask("999.999.999-99");
    $("#phone").inputmask({
        mask: ["(99) 9999-9999", "(99) 99999-9999"],
        keepStatic: true
    });
    $("#cep").inputmask("99.999-999")

    function limpaFormularioCep() {
        $("#address").val("");
        $("#neighborhood").val("");
        $("#city").val("").prop("disabled", false);
        $("#state").html('<option value="">Selecione</option>').prop("disabled", false);
    }

    //CEP
    $("#cep").on("blur", function() {
        const cep = $(this).val().replace(/\D/g, "")

        if(cep != "") {
            const validaCEP = /^[0-9]{8}$/

            if(validaCEP.test(cep)) {
                $("#address").val("...");
                $("#neighborhood").val("...");
                $("#city").val("...");
                $("#state").val("...");

                $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function(dados) {
                    if(!("erro" in dados)) {
                        $("#address").val(dados.logradouro);
                        $("#neighborhood").val(dados.bairro);
                        $("#city").val(dados.localidade).prop("disabled", true);
                        $("#state").html(`<option value="${dados.uf}">${dados.uf}</option>`);
                        $("#state").val(dados.uf).prop("disabled", true)
                    } else {
                        limpa_formulario_cep()
                        alert("CEP não encontrado")
                    }
                })

            } else {
                limpaFormularioCep()
                alert("Formato de CEP inválido.")
            }
        } else {
            limpaFormularioCep()
        }
        
    })
})

// Gerar matrícula automaticamente
function gerarMatricula() {
    const agora = new Date();
    const ano = agora.getFullYear();
    const mes = String(agora.getMonth() + 1).padStart(2, '0')
    const dia = String(agora.getDate()).padStart(2, '0')
    const hora = String(agora.getHours()).padStart(2, '0')
    const minuto = String(agora.getMinutes()).padStart(2, '0')
    const segundo = String(agora.getSeconds()).padStart(2, '0')

    return `M${ano}${mes}${dia}${hora}${minuto}${segundo}`
}

// Formatar a data de inclusão do dado
function formatDate(date) {
    return date.toLocaleString("pt-BR", {
        day: "2-digit",
        month: "2-digit",
        year: "numeric"
    })
}

//Capturar os dados do formulário
formAluno.onsubmit = async function(event) {
    event.preventDefault()

    const matriculaEdit = document.getElementById("matriculaInput")?.value

    const newStudents = {
        matricula: matriculaEdit || gerarMatricula(),
        dataInclusao: formatDate(new Date()),
        name: capitalizeName(nameStudents.value),
        cpf: cpf.value,
        birth: birth.value,
        phone: phone.value,
        course: course.value,
        situation: situation.value,
        sex: sex.value,
        cep: cep.value,
        address: address.value,
        number: addressNumber.value,
        complemento: complemento.value,
        neighborhood: neighborhood.value,
        city: city.value,
        state: state.value
    }

    const formData = new FormData()
    for (const key in newStudents) {
        formData.append(key, newStudents[key])
    }

    try {
        const alertSuccess = document.getElementById("alert-success")
        const alertDanger = document.getElementById("alert-danger")

        const url = matriculaEdit 
            ? "../../ong_solidariedade/controllers/editar_aluno.php" 
            : "../../ong_solidariedade/controllers/salvar_aluno.php"

        const response = await fetch(url, {
            method: "POST",
            body: formData
        })

        const data = await response.json()
        
            if(data.success) {
                //Fecha modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalAluno'))
                if (modal) {
                    document.activeElement.blur();
                    modal.hide()
                }
                //Exibe alerta de Sucesso
                const successMessage = document.getElementById("successMensage")
                if(matriculaEdit) {
                    successMessage.textContent = "Aluno editado com sucesso!"
                } else {
                    successMessage.textContent = "Aluno cadastrado com sucesso!"
                }
                alertSuccess.style.display = "flex"
                alertSuccess.classList.add("show")

                formAluno.reset()

                //Remove o campo oculto de matrícula
                const inputHidden = document.getElementById("matriculaInput")
                if (inputHidden) inputHidden.remove()

                // Destrói o DataTable antes de recarregar os dados
                if ($.fn.DataTable.isDataTable('#tabelaAlunos')) {
                    $('#tabelaAlunos').DataTable().destroy()
                }
                //Recarrega a tabela
                await carregarAlunos()
                //Reinicia o DataTable
                $('#tabelaAlunos').DataTable()
            } else {
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalAluno'))
                if (modal) {
                    document.activeElement.blur();
                    modal.hide()
                }
                //Exibe alerta de Erro
                const dangerMensage = document.getElementById("dangerMensage")
                dangerMensage.textContent = data.message || "Erro ao cadastrar";
                alertDanger.style.display = "flex"
                alertDanger.classList.add("show")
            }

    } catch (error) {
        console.error("Error:", error)
        alert("Erro ao enviar os dados")
    }

}

// Visualizar e editar os dados do aluno
document.querySelector("#tabelaAlunos").addEventListener("click", async (e) => {
    // Visualizar os dados do aluno
    if(e.target.closest("#btnDetalhes")) {
        const btn = e.target.closest("#btnDetalhes")
        const matricula = btn.dataset.matricula
        
        const response = await fetch(`../../ong_solidariedade/controllers/detalhar_aluno.php?matricula=${matricula}`)
        const json = await response.json()

        
        if(!json.success) {
            alert("Erro ao buscar aluno: " + json.error)
            return
        }
        
        const aluno = json.data
        
        // Preencher os campos do modal com os dados do aluno
        document.getElementById('nameStudents').value = aluno.name;
        document.getElementById('cpf').value          = aluno.cpf;
        document.getElementById('birth').value        = aluno.birth;
        document.getElementById('phone').value        = aluno.phone ?? '';
        document.getElementById('course').value       = aluno.course;
        document.getElementById('situation').value    = aluno.situation;
        document.getElementById('sex').value          = aluno.sex;
        document.getElementById('cep').value          = aluno.cep;
        document.getElementById('address').value      = aluno.address;
        document.getElementById('number').value       = aluno.number ?? '';
        document.getElementById('complemento').value  = aluno.complemento ?? '';
        document.getElementById('neighborhood').value = aluno.neighborhood ?? '';
        document.getElementById('city').value         = aluno.city;
        document.getElementById('state').value        = aluno.state;
        
        // Deixar os campos do modal como somente leitura
        [...document.querySelectorAll("#formAluno input, #formAluno select")].forEach(el => {
            el.readOnly = true
            el.disabled = true
        })
        
        //Esconder botão de Salvar
        document.getElementById("btnSubmit").style.display = "none"
        
        // Alterar o título do modal
        document.querySelector("#modalAluno #modalAlunoLabel").textContent = "Detalhes do Aluno"
        
        // Mostrar o modal
        const modal = new bootstrap.Modal(document.getElementById("modalAluno"))
        modal.show()
    }

    // Editar os dados do aluno
    if(e.target.closest("#btnEditar")) {
        const btn = e.target.closest("#btnEditar")
        const matricula = btn.dataset.matricula
        
        const response = await fetch(`../../ong_solidariedade/controllers/detalhar_aluno.php?matricula=${matricula}`)
        const json = await response.json()

        if(!json.success) {
            alert("Erro ao buscar aluno: " + json.error)
            return
        }

        const aluno = json.data
        // Preencher os campos do modal com os dados do aluno
        document.getElementById('nameStudents').value = aluno.name;
        document.getElementById('cpf').value          = aluno.cpf;
        document.getElementById('birth').value        = aluno.birth;
        document.getElementById('phone').value        = aluno.phone ?? '';
        document.getElementById('course').value       = aluno.course;
        document.getElementById('situation').value    = aluno.situation;
        document.getElementById('sex').value          = aluno.sex;
        document.getElementById('cep').value          = aluno.cep;
        document.getElementById('address').value      = aluno.address;
        document.getElementById('number').value       = aluno.number ?? '';
        document.getElementById('complemento').value  = aluno.complemento ?? '';
        document.getElementById('neighborhood').value = aluno.neighborhood ?? '';
        document.getElementById('city').value         = aluno.city;
        document.getElementById('state').value        = aluno.state;

        // Deixar os campos do modal como editáveis
        [...document.querySelectorAll("#formAluno input, #formAluno select")].forEach(el => {
            el.readOnly = false
            el.disabled = false
        })

        // Alterar o título do modal
        document.querySelector("#modalAluno #modalAlunoLabel").textContent = "Editar Aluno"

        // Mostrar o botão de Salvar
        document.getElementById("btnSubmit").style.display = "inline-block"

        //Adicionar campo oculto com a matrícula
        let inputHidden = document.getElementById("matriculaInput")
        if(!inputHidden) {
            inputHidden = document.createElement("input")
            inputHidden.type = "hidden"
            inputHidden.id = "matriculaInput"
            inputHidden.name = "matriculaInput"
            formAluno.appendChild(inputHidden)
        }
        inputHidden.value = aluno.matricula

        // Mostrar o modal
        const modal = new bootstrap.Modal(document.getElementById("modalAluno"))
        modal.show()
    }
})

// Retorna o modal ao estado inicial
document.getElementById("modalAluno").addEventListener("hidden.bs.modal", () => {
    [...document.querySelectorAll("#formAluno input, #formAluno select")].forEach(el => {
        el.readOnly = false
        el.disabled = false
    })

    document.getElementById("btnSubmit").style.display = "inline-block"
    document.querySelector("#modalAluno #modalAlunoLabel").textContent = "Cadastrar Aluno"
    document.getElementById('formAluno').reset();

})

// Excluir aluno
async function excluirAluno() {
    console.log("matriculaExcluir:", matriculaExcluir);
    if(!matriculaExcluir) return

    try {
        const response = await fetch("../../ong_solidariedade/controllers/excluir_aluno.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `matricula=${encodeURIComponent(matriculaExcluir)}`
        })

        const data = await response.json()

        if(data.success) {
            const modalEl = document.getElementById("modalConfirmarExclusao")
            const modal = bootstrap.Modal.getInstance(modalEl);
            document.activeElement.blur();
            modal.hide();

            alert("Aluno excluído com sucesso!")

            if($.fn.DataTable.isDataTable('#tabelaAlunos')) {
                $('#tabelaAlunos').DataTable().destroy()
            }

            await carregarAlunos()
            $('#tabelaAlunos').DataTable()
        } else {
            alert("Erro ao excluir: " + (data.message || "Erro desconhecido."))
        }
    } catch (error) {
        console.error("Erro ao excluir aluno:", error)
        alert("Erro na requisição.")
    } finally {
        // Limpa a variável de matrícula
        matriculaExcluir = null
    }
}
