console.log('connected');

const btnAddStep = document.querySelector('#add-step');
const stepsFieldset = document.querySelector('#steps-fieldset');
let stepCount = stepsFieldset ? stepsFieldset.querySelectorAll('textarea').length : 0;

function addStepInput() {
    const div = document.createElement('div');
    const label = document.createElement('label');
    label.setAttribute('for', 'Step ${stepCount}');
    label.textContent = (`Step ${stepCount + 1}`);
    const textarea = document.createElement('textarea');
    textarea.type='text';
    textarea.required = true;
    textarea.id = `step-${stepCount + 1}`;
    textarea.name = 'step[]';
    div.append(label);
    div.append(textarea);

    if (stepsFieldset) {
        stepsFieldset.append(div);
        textarea.focus();
        stepCount = stepCount + 1;
    }
}

btnAddStep.addEventListener('click', addStepInput);

