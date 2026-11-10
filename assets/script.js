console.log('connected');

const btnAddStep = document.querySelector('#-step');
const stepsFieldset = document.querySelector('#steps-fieldset');
let stepCount = 0;

function addStepInput() {
    console.log('addstepinput called');
    const div = document.createElement('div');
    console.log('div created');
    const label = document.createElement('label');
    console.log('label created');
    label.setAttribute('for', 'Step ${stepCount}');
    console.log('label attributeset');
    label.textContent = 'Step ${stepCount + 1}';
    console.log('stepcount updated');
    const input = document.createElement('input');
    console.log('input created');
    input.type='text'
        .required = true
        .id = 'step-${step-count}'
        .name = 'step[]'
    div.append(label)
    console.log('label appended');
    div.append(input)
    console.log('input appended');

    if (stepsFieldset) {
        stepsFieldset.append(div);
        input.focus();
        stepCount = stepCount + 1;
    }

    if (btnAddStep) {
        btnAddStep.addEventListener('click', addStepInput());
    }
    //is type="button" ok on the button or would it be better to preventdefault here?
}

