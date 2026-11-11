console.log('connected');

const btnAddStep = document.querySelector('#add-step');
const stepsFieldset = document.querySelector('#steps-fieldset');
let stepCount = 0;

function addStepInput() {
    const div = document.createElement('div');
    const label = document.createElement('label');
    label.setAttribute('for', 'Step ${stepCount}');
    label.textContent = (`Step ${stepCount + 1}`);
    const input = document.createElement('input');
    input.type='text';
    input.required = true;
    input.id = `step-${stepCount}`;
    input.name = 'step[]';
    div.append(label);
    div.append(input);

    if (stepsFieldset) {
        stepsFieldset.append(div);
        input.focus();
        stepCount = stepCount + 1;
    }
}

// `${nameValue}, User`

btnAddStep.addEventListener('click', addStepInput);

// btnAddStep.addEventListener('click', function (event) {
//     addStepInput()
// }
