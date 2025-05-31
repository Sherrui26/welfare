document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const activityLogModal = document.getElementById('activityLogModal');
    const activityDetailsModal = document.getElementById('activityDetailsModal');
    const closeActivityLogModal = document.getElementById('closeActivityLogModal');
    const closeActivityDetailsModal = document.getElementById('closeActivityDetailsModal');
    const backToActivityLogModal = document.getElementById('backToActivityLogModal');
    const viewActivityButtons = document.querySelectorAll('.view-activity-btn');
    
    // Sample activity data (in a real app, this would come from a database)
    const activityData = [
        {
            type: 'Admin',
            typeClass: 'bg-purple-100 text-purple-800',
            user: 'John Doe',
            role: 'Admin',
            department: 'Management',
            ipAddress: '192.168.1.45',
            action: 'Added new tenant',
            actionType: 'Create',
            actionResource: 'Tenant Record',
            actionStatus: 'Completed',
            actionDuration: '2.4 seconds',
            date: 'Oct 1, 2023',
            time: '10:25 AM',
            summary: 'Added new tenant to the system with room assignment.',
            changedFields: [
                { field: 'Tenant Name', oldValue: '-', newValue: 'Ahmad Zaki' },
                { field: 'Room Number', oldValue: '-', newValue: '101' },
                { field: 'ID Number', oldValue: '-', newValue: '88159831' }
            ],
            systemNotes: 'Action performed through the web interface. Tenant record successfully created with all required fields. Email notification sent to administrative staff.'
        },
        {
            type: 'Staff',
            typeClass: 'bg-blue-100 text-blue-800',
            user: 'Jane Smith',
            role: 'Maintenance',
            department: 'Facilities',
            ipAddress: '192.168.1.87',
            action: 'Resolved maintenance ticket',
            actionType: 'Update',
            actionResource: 'Maintenance Request',
            actionStatus: 'Completed',
            actionDuration: '5.1 seconds',
            date: 'Oct 2, 2023',
            time: '2:15 PM',
            summary: 'Resolved maintenance ticket #4582 for Room 202.',
            changedFields: [
                { field: 'Status', oldValue: 'In Progress', newValue: 'Resolved' },
                { field: 'Resolution Notes', oldValue: '-', newValue: 'Fixed water leak in bathroom sink.' }
            ],
            systemNotes: 'Maintenance ticket closed successfully. Follow-up inspection scheduled for tomorrow.'
        },
        {
            type: 'System',
            typeClass: 'bg-gray-100 text-gray-800',
            user: 'System',
            role: 'Automated',
            department: 'N/A',
            ipAddress: 'localhost',
            action: 'Daily backup completed',
            actionType: 'Backup',
            actionResource: 'Database',
            actionStatus: 'Completed',
            actionDuration: '45.7 seconds',
            date: 'Oct 3, 2023',
            time: '1:00 AM',
            summary: 'Automated daily backup of the system database completed successfully.',
            changedFields: [],
            systemNotes: 'Backup stored in secure cloud storage. Retention policy: 30 days. Next backup scheduled for tomorrow at 1:00 AM.'
        },
        {
            type: 'Admin',
            typeClass: 'bg-purple-100 text-purple-800',
            user: 'Sarah Wong',
            role: 'Admin',
            department: 'Management',
            ipAddress: '192.168.1.112',
            action: 'Modified room allocation',
            actionType: 'Update',
            actionResource: 'Room Assignment',
            actionStatus: 'Completed',
            actionDuration: '3.2 seconds',
            date: 'Oct 3, 2023',
            time: '3:45 PM',
            summary: 'Updated room assignments for 5 occupants due to maintenance in Block B.',
            changedFields: [
                { field: 'Room 305', oldValue: 'Vacant', newValue: 'Occupied' },
                { field: 'Room 306', oldValue: 'Vacant', newValue: 'Occupied' },
                { field: 'Room 307', oldValue: 'Vacant', newValue: 'Occupied' }
            ],
            systemNotes: 'Room allocations updated due to scheduled maintenance in Block B. Affected occupants have been notified via SMS.'
        },
        {
            type: 'Staff',
            typeClass: 'bg-blue-100 text-blue-800',
            user: 'Mike Johnson',
            role: 'Security',
            department: 'Security',
            ipAddress: '192.168.1.65',
            action: 'Completed security inspection',
            actionType: 'Inspection',
            actionResource: 'Building Security',
            actionStatus: 'Completed',
            actionDuration: '35.8 minutes',
            date: 'Oct 4, 2023',
            time: '9:15 AM',
            summary: 'Completed monthly security inspection of all building perimeters and access points.',
            changedFields: [
                { field: 'Last Inspection Date', oldValue: 'Sep 4, 2023', newValue: 'Oct 4, 2023' },
                { field: 'Security Rating', oldValue: '95%', newValue: '98%' }
            ],
            systemNotes: 'Inspection report filed electronically. Two minor issues identified and maintenance tickets created.'
        }
    ];
});
