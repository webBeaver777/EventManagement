import { fetchEvents } from './events-utils';

document.addEventListener('DOMContentLoaded', () => {
    fetchEvents('/api/events', 'all-events-tbody');
    fetchEvents('/api/events/my', 'my-events-tbody');
    setInterval(() => fetchEvents('/api/events', 'all-events-tbody'), 30000);
    setInterval(() => fetchEvents('/api/events/my', 'my-events-tbody'), 30000);
});
