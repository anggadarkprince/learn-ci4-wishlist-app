import variables from './variables';

export default function () {

    const SUBSCRIBE_TASK = 'task';
    const SUBSCRIBE_ACTIVITY = 'activity';

    const EVENT_TASK_ASSIGNMENT = 'task-assignment';
    const EVENT_ACTIVITY_REPORTING = 'activity-reporting';
    const EVENT_ACTIVITY_VALIDATION = 'activity-validation';

    function displayNotification(title, message, url) {
        let options = {
            body: message,
            icon: variables.baseUrl + 'assets/dist/img/layouts/icon.png',
        };
        const notification = new Notification(title, options);
        notification.onclick = function () {
            window.open(url);
        };
    }

    if (variables.userId) {
        if ('Notification' in window) {
            if (Notification.permission !== "granted") {
                Notification.requestPermission(function (result) {
                    console.log('User choice', result);
                    if (result !== 'granted') {
                        console.log('No notification permission granted');
                    } else {
                        displayNotification('Successfully subscribed!', 'You successfully subscribe to our notification service!');
                    }
                });
            } else {
                //Pusher.logToConsole = true;

                let pusher = new Pusher('26e6e8709320db34adbb', {
                    cluster: 'ap1',
                    encrypted: true
                });

                let channelAR = pusher.subscribe(`${SUBSCRIBE_TASK}-${variables.userId}`);
                channelAR.bind(EVENT_TASK_ASSIGNMENT, function (data) {
                    displayNotification('Task Assignment', data.message, data.url);
                });

                let channelAP = pusher.subscribe(`${SUBSCRIBE_ACTIVITY}-${variables.userId}`);
                channelAP.bind(EVENT_ACTIVITY_REPORTING, function (data) {
                    displayNotification('Activity Reporting', data.message, data.url);
                });
                channelAP.bind(EVENT_ACTIVITY_VALIDATION, function (data) {
                    displayNotification('Activity Validation', data.message, data.url);
                });

            }
        } else {
            console.log('Not support notification');
        }
    }

};
