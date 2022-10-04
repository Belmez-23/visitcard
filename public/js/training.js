//1. COMPLETE VARIABLE AND FUNCTION DEFINITIONS
const customX = document.getElementById('customx');
const customY = document.getElementById('customy');
const customZ = document.getElementById('customz');
const randomize = document.querySelector('.randomize');
const story = document.querySelector('.story');

function randomValueFromArray(array) {
    const random = Math.floor(Math.random() * array.length);
    return array[random];
}

//2. RAW TEXT STRINGS
let storyText = 'На улице было 94 градуса по Фаренгейту, поэтому :insertx: отправился на прогулку. Добравшись до :inserty:, он несколько мгновений в ужасе смотрел на него, а затем :insertz:. Прохожий видел все это, но не удивился — :insertx: весит 300 фунтов, а день был жаркий.'

let insertX = [
    'Мальчик Бобби',
    'Большой папочка',
    'Дед Мороз'
]

let insertY = [
    'Теремка',
    'Острова мечты',
    'Дома правительства'
]

let insertZ = [
    'самовоспламенился',
    'растаял в лужу на тротуаре',
    'превратился в слизняка и уполз прочь'
]

///3. EVENT LISTENER AND PARTIAL FUNCTION DEFINITION

randomize.addEventListener('click', result);

function result() {

    let newStory = storyText;
    let xItem = customX.value !== '' ? customX.value: randomValueFromArray(insertX);
    let yItem = customY.value !== '' ? customY.value: randomValueFromArray(insertY);
    let zItem = customZ.value !== '' ? customZ.value: randomValueFromArray(insertZ);

    newStory = newStory.replaceAll(':insertx:', xItem);
    newStory = newStory.replace(':inserty:', yItem);
    newStory = newStory.replace(':insertz:', zItem);

    if (document.getElementById("ru").checked) {
        newStory = newStory.replace('94 градуса по Фаренгейту', Math.round((94 - 32) / 1.8) + ' градуса по Цельсию');
        newStory = newStory.replace('300 фунтов', Math.round(300 / 2.2046) + ' килограмм');
    }

    story.textContent = newStory;
    story.style.visibility = 'visible';
}

//https://developer.mozilla.org/ru/docs/Learn/JavaScript/First_steps/Silly_story_generator

