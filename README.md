# AI Service Management API

A robust, centralized platform built with Laravel for managing AI service subscriptions and fulfillment. This API acts as a secure gateway between AI capabilities and end-users, enforcing role-based access control and automated subscription workflows.

## Key Features
- **Admin & Client Roles**: Distinct permissions for system administrators and end-users.
- **Service & Plan Management**: Admins can define AI services (e.g., Image Analysis) and tiered subscription plans.
- **Approval Workflow**: Streamlined process for users to request and admins to approve/reject subscriptions.
- **AI Fulfillment**: Integration with the Ollama API for automated request fulfillment with status tracking.
- **Automated Tasks**: Background jobs for subscription expiration and limit enforcement.
- **Secure Authentication**: Protected via Laravel Sanctum tokens.

---

## Tech Stack
- **Framework**: Laravel 12 (PHP)
- **Authentication**: Laravel Sanctum
- **Database**: Relational Database
- **AI Engine**: Ollama (Local/Cloud integration)
- **Email**: Mailguin/SMTP for notifications

---

## 📖 API Documentation

**Base URL**: `http://your-domain.com/api`

### Authentication
| Method | Endpoint | Description | Role |
| :--- | :--- | :--- | :--- |
| `POST` | `/register` | Register a new client account | Public |
| `POST` | `/login` | Login to receive a Sanctum token | Public |
| `POST` | `/logout` | Invalidate the current session token | Both |

### Service & Plan Management (Common)
| Method | Endpoint | Description | Role |
| :--- | :--- | :--- | :--- |
| `GET` | `/services` | List all available services and their active plans | Both |

### Client Portal
| Method | Endpoint | Description | Role |
| :--- | :--- | :--- | :--- |
| `POST` | `/submit-subscription-request` | Request a subscription to a specific plan | Client |
| `POST` | `/ai-request` | Submit a prompt for AI fulfillment | Client |
| `GET` | `/ai-request/my-ai-requests` | View your personal AI request history | Client |
| `GET` | `/ai-request/{id}` | View details of a specific AI request | Client |

### Admin Dashboard
#### Service Management
| Method | Endpoint | Description | Role |
| :--- | :--- | :--- | :--- |
| `POST` | `/admin/create-service` | Define a new AI service | Admin |
| `PUT` | `/admin/service/update/{id}` | Update service metadata | Admin |
| `DELETE` | `/admin/service/delete/{id}` | Remove a service from the catalog | Admin |

#### Plan Management
| Method | Endpoint | Description | Role |
| :--- | :--- | :--- | :--- |
| `POST` | `/admin/create-plan` | Create a tiered plan for a service | Admin |
| `GET` | `/admin/allPlans` | List all plans in the system | Admin |
| `PUT` | `/admin/updatePlan/{id}` | Update plan pricing/limits | Admin |
| `DELETE` | `/admin/deletePlan/{id}` | Delete a plan | Admin |
| `PUT` | `/admin/activatePlan/{id}` | Activate a plan for public view | Admin |
| `PUT` | `/admin/deactivatePlan/{id}` | Hide a plan from subscriptions | Admin |

#### Subscription Workflow
| Method | Endpoint | Description | Role |
| :--- | :--- | :--- | :--- |
| `GET` | `/admin/get-pendnig-requests` | View all pending user subscription requests | Admin |
| `PUT` | `/admin/approve-subscription-requests/{id}` | Approve and activate a subscription | Admin |
| `PUT` | `/admin/reject-subscription-requests/{id}` | Reject a subscription request | Admin |

#### AI Fulfillment Operations
| Method | Endpoint | Description | Role |
| :--- | :--- | :--- | :--- |
| `GET` | `/admin/ai-requests` | View all system-wide AI requests | Admin |
| `PUT` | `/admin/ai-request/update-status/{id}` | Manually update status/deliver AI results | Admin |

---

## Automated Notifications
Clients receive automated emails for:
- Welcome message upon registration.
- Confirmation of subscription submission.
- Approval/Rejection status updates.

---

## Entity Relationship Diagram
<img width="1331" height="1272" alt="Ai-Service-Management-System (1)" src="https://github.com/user-attachments/assets/45b58d25-7141-4e4a-95a4-8aebe2c1a12d" />

