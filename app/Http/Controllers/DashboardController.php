<?php

namespace App\Http\Controllers;


use App\Models\Player;
use App\Models\PlayerQueue;
use App\Models\QuestionV2;
use App\Models\Quiz;
use App\Models\QuizAnswer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    //====================================================>
    public function login(Request $request)
    {
        $this->seo()->setTitle('CheckIN And Start');
        return view('dashboard.login');
    }

    //====================================================>
    public function doLogin(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric|digits:4'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $code = $request->input('user_id');

        try {
            $player = Player::where('uuid', $code)->firstOrFail();
            $queue = PlayerQueue::where('player_id', $player->id)->where('status', false)->whereDate('created_at', Carbon::today())->first();
            if ($queue == null) {
                $newQueue = new PlayerQueue;
                $newQueue->player_id = $player->id;
                $newQueue->save();
                return view('dashboard.done-check', ['msg' => 'Done']);
            }
            return view('dashboard.done-check', ['msg' => 'You are already checked in.']);
        } catch (ModelNotFoundException  $e) {
            return back()->withErrors(['user_id' => 'The entered code is invalid. Please contact the registration']);
        }
    }

    //====================================================>
    //====================================================>
    public function index()
    {
        $this->seo()->setTitle('Dashboard Home');
        return view('dashboard.index');
    }

    //====================================================>
    public function leader()
    {

        $this->seo()->setTitle('Leader Board');
        return view('dashboard.leader', ['quiz' => null]);
    }

    //====================================================>
    public function leaderAjax(Request $request)
    {
        if ($request->ajax()) {
            $data = Quiz::select(['id', 'player_id', 'score', 'duration'])->with([
                'Player' => function ($q) {
                    $q->select('id', 'name', 'phone', 'uuid');
                },
                'QuizAnswer'
            ])->orderBy('score', 'desc')->where('status', true)->get();//->unique('player_id');

            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('name', function ($row) {
                    return $row->Player->name;
                })
                ->editColumn('phone', function ($row) {
                    return $row->Player->phone ?? '';
                })
                ->editColumn('code', function ($row) {
                    return $row->Player->uuid ?? '';
                })
                /*
                                ->addColumn('scorex', function ($row) {
                                    $total = 0;
                                    $correct = 0;
                                    $correct_reward = 900000;

                                    foreach ($row->QuizAnswer as $ans) {
                                        if (!$ans->is_correct)
                                            continue;

                                        $interval = $ans->end_datetime->diff($ans->start_datetime);
                                        $totalMS = 0;
                                        $totalMS += $interval->m * 2630000000;
                                        $totalMS += $interval->d * 86400000;
                                        $totalMS += $interval->h * 3600000;
                                        $totalMS += $interval->i * 60000;
                                        $totalMS += $interval->s * 1000;

                                        $total += $totalMS;
                                        $correct++;
                                    }

                                    if($total >= 600000){
                                        $total = 600000;
                                    }

                                    $score = (($correct * $correct_reward) - $total) / 1000;

                                    if($score < 0){
                                        $score = 0;
                                    }
                                    return $score;

                                })
                */
                ->make(true);
        }
        return '';
    }

    //====================================================>
    public function players()
    {

        $this->seo()->setTitle('Players');
        return view('dashboard.players');
    }

    //====================================================>
    public function playersAjax(Request $request)
    {
        if ($request->ajax()) {

            $data = Player::with([
                'Quiz' => function ($q) {
                    $q->select('player_id', 'score')->orderBy('score', 'desc');
                }
            ]);//->get();

            return Datatables::of($data)
                ->filter(function ($query) {
                    if (request()->has('search')) {
                        $query->where(function ($wQuery) {
                            $wQuery->where('name', 'like', '%' . request('search')['value'] . '%');
                            $wQuery->orWhere('phone', "%" . request('search')['value'] . "%");
                        });
                    }
                })
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return $row->uuid;
                    //return '<a data-code="'.$row->uuid.'" href="javascript:void(0)" class="font-medium text-blue-600 dark:text-blue-500 hover:underline show-code">Code</a>';
                })
                ->rawColumns(['action'])
                ->addColumn('max_score', function ($row) {
                    return $row->Quiz[0]->score ?? 0;
                })
                ->addColumn('quiz_count', function ($row) {
                    return count($row->Quiz) ?? 0;
                })
                ->make(true);
        }
        return '';
    }

    //====================================================>
    public function deleteAll(Request $request)
    {
        //$returnArray['success'] = false;

        Quiz::truncate();
        QuizAnswer::truncate();
        PlayerQueue::truncate();

        //Player::truncate();

        $returnArray['success'] = true;
        return Response::json($returnArray);
    }

    //====================================================>
    public function QData()
    {


        $jayParsedAry = [
            "application_security" => [
                [
                    "answer_1" => "To reduce the likelihood of unauthorized access by implementing complex, hard-to-guess passwords",
                    "answer_2" => "To confuse users",
                    "question" => "What is the purpose of strong password policies in application security?",
                    "answer_3" => "To speed up the login process",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "Why should you avoid using the same password for multiple applications?",
                    "answer_1" => "Compromising one password can potentially give an attacker access to multiple systems and applications",
                    "answer_2" => "To make tracking password changes more difficult",
                    "answer_3" => "It is unnecessary",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "Which of the following is a common method to protect sensitive data in applications?",
                    "answer_1" => "Encrypting data",
                    "answer_2" => "Storing data in plain text",
                    "answer_3" => "Using weak passwords",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "Why is it important to regularly update software and applications?",
                    "answer_1" => "To patch security vulnerabilities",
                    "answer_2" => "To get new features",
                    "answer_3" => "To delete old files",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "What is two-factor authentication (2FA) and why is it important?",
                    "answer_1" => "An additional security layer that requires a second form of identification",
                    "answer_2" => "A way to avoid passwords",
                    "answer_3" => "A method to log in faster",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "Which of the following should you avoid clicking on in emails to prevent phishing attacks?",
                    "answer_1" => "Links from unknown senders",
                    "answer_2" => "Calendar reminders",
                    "answer_3" => "Company announcements",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "What should you do if you suspect an application you use has been compromised?",
                    "answer_1" => "Report it to  Security Operations Team  immediately",
                    "answer_2" => "Continue using it as usual",
                    "answer_3" => "Uninstall it and forget about it",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "What is the primary purpose of input validation in applications?",
                    "answer_1" => "To ensure that only valid data is entered, preventing attacks ",
                    "answer_2" => "To organize data efficiently",
                    "answer_3" => "To improve user experience",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "Which of the following is an example of a secure coding practice?",
                    "answer_1" => "Validating all user inputs",
                    "answer_2" => "Storing passwords in plain text",
                    "answer_3" => "Hardcoding credentials in the application",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "What is the purpose of HTTPS in web applications?",
                    "answer_1" => "To encrypt data transmitted between the user and the server",
                    "answer_2" => "To speed up website loading times",
                    "answer_3" => "To store cookies",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "Why is it important to use secure APIs in application development?",
                    "answer_1" => "To prevent unauthorized access and data breaches",
                    "answer_2" => "To allow more users to access the application",
                    "answer_3" => "To make the code simpler",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "What does the principle of \"least privilege\" mean in the context of application security?",
                    "answer_1" => "Limiting access rights for users to the bare minimum they need to perform their jobs",
                    "answer_2" => "Allowing administrators to have unrestricted access",
                    "answer_3" => "Giving all users the same level of access",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "Why is code review important in application security?",
                    "answer_1" => "To identify and fix security vulnerabilities in the code before deployment",
                    "answer_2" => "To improve application performance",
                    "answer_3" => "To reduce the size of the codebase",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "Which of the following is a secure method of storing passwords?",
                    "answer_1" => "Hashing passwords with a strong algorithm like bcrypt",
                    "answer_2" => "Using weak encryption methods",
                    "answer_3" => "Saving them in a text file on the server",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "What is the role of a Web Application Firewall (WAF)?",
                    "answer_1" => "To protect web applications by filtering and monitoring HTTP traffic",
                    "answer_2" => "To encrypt data in transit",
                    "answer_3" => "To manage user authentication",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "When deploying a commercial software I should:",
                    "answer_1" => "Develop a security configuration baseline",
                    "answer_2" => "Not change the admin password for recovery purposes",
                    "answer_3" => "Conduct source code scan ",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "Mobile error messages must never _____.",
                    "answer_1" => "Transmitted to 3rd parties",
                    "answer_2" => "Be displayed in multiple languages",
                    "answer_3" => "Include instructions for troubleshooting common user issues",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "Mobile applications must include protection against running on _______.",
                    "answer_1" => "Rooted devices & outdated operating systems",
                    "answer_2" => "Devices with multiple user accounts",
                    "answer_3" => "Devices with low battery levels",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "Why is it important to back up your data regularly?",
                    "answer_1" => "To ensure data can be restored in case of loss or ransomware attack",
                    "answer_2" => "To free up space",
                    "answer_3" => "To improve system performance",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "Where should developers store corporate source code?",
                    "answer_1" => "Corporate approved code repositories such as Bitbucket",
                    "answer_2" => "Public code repositories",
                    "answer_3" => "Developer workstation",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "During a SAST scan, which type of security issues would you expect to be identified?",
                    "answer_1" => "Hardcoded credentials, insecure coding practices, and potential injection flaws in the source code ",
                    "answer_2" => "Network configuration errors",
                    "answer_3" => "Unauthorized access attempts in real-time",
                    "correct_answer" => 1,
                    "security_level" => "difficult"
                ],
                [
                    "question" => "Software Composition Analysis (SCA) can help in:",
                    "answer_1" => "Scans & identifies vulnerabilities & outdated versions in third-party libraries used within applications",
                    "answer_2" => "Optimizing the performance of your application by refactoring third-party code",
                    "answer_3" => "Ensures that third-party components are visually appealing",
                    "correct_answer" => 1,
                    "security_level" => "difficult"
                ],
                [
                    "question" => "When downloading third-party libraries for an application, where is the safest place to acquire them?",
                    "answer_1" => "From reputable and official package repositories or trusted sources that provide verified and secure versions",
                    "answer_2" => "From obscure, unofficial GitHub repositories without proper vetting",
                    "answer_3" => "Via unofficial or peer-to-peer sharing",
                    "correct_answer" => 1,
                    "security_level" => "difficult"
                ],
                [
                    "question" => "What does \"defense in depth\" mean for application security?",
                    "answer_1" => "Multiple security layers for redundancy ",
                    "answer_2" => "Single strong security layer",
                    "answer_3" => "Perimeter-only protection",
                    "correct_answer" => 1,
                    "security_level" => "difficult"
                ],
                [
                    "question" => "What is the benefit of using OAuth 2.0 over basic authentication for APIs?",
                    "answer_1" => "Secure tokens with scopes and expiry",
                    "answer_2" => "Encrypts API traffic",
                    "answer_3" => "Removes authentication needs",
                    "correct_answer" => 1,
                    "security_level" => "difficult"
                ],
                [
                    "question" => "What does the term \"sandboxing\" refer to in the context of application security?",
                    "answer_1" => "Running applications in isolated environments",
                    "answer_2" => "Encrypting application data",
                    "answer_3" => "Using firewalls to block external threats",
                    "correct_answer" => 1,
                    "security_level" => "difficult"
                ],
                [
                    "question" => "What does the term \"secure software development lifecycle(SDLC)\" refer to?",
                    "answer_1" => "An approach that integrates security practices and testing throughout the entire development process ",
                    "answer_2" => "A methodology for managing software projects",
                    "answer_3" => "A set of tools for code optimization",
                    "correct_answer" => 1,
                    "security_level" => "difficult"
                ],
                [
                    "question" => "____ attack is a type of attack against an application that parses XML input.",
                    "answer_1" => "XXE",
                    "answer_2" => "HTML",
                    "answer_3" => "XSS",
                    "correct_answer" => 1,
                    "security_level" => "difficult"
                ],
                [
                    "question" => "Why is it important to implement Certificate or public key miining for mobile applications?",
                    "answer_1" => "To protect against man-in-the-middle attack",
                    "answer_2" => "To manage encryption keys periodically",
                    "answer_3" => "To simplify the implementation of multi-factor authentication mechanisms",
                    "correct_answer" => 1,
                    "security_level" => "difficult"
                ],
                [
                    "question" => "API access tokens must be issued by ______.",
                    "answer_1" => "Centralized Oauth server",
                    "answer_2" => "Any public API endpoint for ease of use",
                    "answer_3" => "The client application itself to reduce server load",
                    "correct_answer" => 1,
                    "security_level" => "difficult"
                ],
                [
                    "question" => "What is a \"zero - day\" vulnerability?",
                    "answer_1" => "A security flaw that is unknown to the software vendor and has no available patch",
                    "answer_2" => "A bug that affects only zero-day applications",
                    "answer_3" => "A flaw in software that only occurs on the first day of its release",
                    "correct_answer" => 1,
                    "security_level" => "difficult"
                ],
                [
                    "question" => "HTTPS, SFTP and TLS are examples of:",
                    "answer_1" => "Secure web applications and communication protocols",
                    "answer_2" => "File Transfer Protocols",
                    "answer_3" => "Mail Transfer Protocols",
                    "correct_answer" => 1,
                    "security_level" => "difficult"
                ]
            ],
            "cloud" => [
                [
                    "question" => "What is recommend for ensuring data integrity in cloud environments?",
                    "answer_1" => "Use of hashing algorithms",
                    "answer_2" => "Implementing network firewalls",
                    "answer_3" => "Using only private cloud solutions",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "To secure cloud applications, you should:",
                    "answer_1" => "Conduct regular vulnerability assessments",
                    "answer_2" => "Rely on strong passwords alone",
                    "answer_3" => "Implement end-point security ",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "What is a best practice for securing container image configurations?",
                    "answer_1" => "Use only signed and trusted container images",
                    "answer_2" => "Use unverified third-party container images",
                    "answer_3" => "Ignore image provenance",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "Which of the following is recommended for limiting the risk of container breakout attacks?",
                    "answer_1" => "Running containers with the least privilege necessary",
                    "answer_2" => "Running containers with root privileges",
                    "answer_3" => "Disabling container isolation features",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "What is a critical step for securing container orchestration systems like Kubernetes?",
                    "answer_1" => "Enforcing Role-Based Access Control (RBAC) for Kubernetes clusters",
                    "answer_2" => "Always using default Kubernetes settings",
                    "answer_3" => "Disabling network segmentation",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "Cloud Service Providers, providers manage and secure all the following except:",
                    "answer_1" => "Access Control",
                    "answer_2" => "Infrastructure",
                    "answer_3" => "Operating System",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "Which data is not be suitable for public clouds?",
                    "answer_1" => "Corporate contracts & legal agreements",
                    "answer_2" => "Corporate news and annoucments",
                    "answer_3" => "Published papers with 3rd party",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "Which is not a form of confidential computing?",
                    "answer_1" => "Zero-trust networks",
                    "answer_2" => "Secure multiparty computation",
                    "answer_3" => "Trust execution environments",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "Cloud Access Security Broker (CASB) can help enterprises boost security through:",
                    "answer_1" => "Monitoring and enforcing security policies between cloud service consumers and providers",
                    "answer_2" => "Storing encryption keys for cloud-based databases",
                    "answer_3" => "Providing antivirus protection for cloud applications",
                    "correct_answer" => 1,
                    "security_level" => "difficult"
                ],
                [
                    "question" => "Appliation data hosted in the cloud, must be stored in ________. ",
                    "answer_1" => "Saudi Arabia",
                    "answer_2" => "In any country with advanced cloud infrastructure",
                    "answer_3" => "In GCC countries with strong data centers",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "Prior to subscribing to a cloud service provider, the cloud service tenant must request ______.",
                    "answer_1" => "Cloud Computing Assessment",
                    "answer_2" => "The price",
                    "answer_3" => "Pre-Go-Live Assessment",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "Prior to launching a cloud solution, the cloud service tenant must request ____.",
                    "answer_1" => "Pre-Go-Live Assessment",
                    "answer_2" => "Cloud Computing Assessment",
                    "answer_3" => "Corporate Announcement Review ",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "Self compliance assessment must be conducted against cloud solutions once every _____.",
                    "answer_1" => "Year",
                    "answer_2" => "Two Years",
                    "answer_3" => "5 Years",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "When subscribing to a cloud solution, security logs must be ____.",
                    "answer_1" => "Shipped to corporate log management solution",
                    "answer_2" => "Documented and stored",
                    "answer_3" => "Secured with a strong password",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "What is an effective strategy for managing identities and access in the cloud?",
                    "answer_1" => "Centralized management of identities and access",
                    "answer_2" => "Decentralizing user accounts and permissions",
                    "answer_3" => "Allow users to register and have local accounts",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "What does the concept of ‘security by design’ entail in cloud computing?",
                    "answer_1" => "Integrating security throughout the development lifecycle",
                    "answer_2" => "Prioritizing performance over security",
                    "answer_3" => "Focusing solely on physical security measures",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "Which Google Cloud service is designed to secure your software supply chain by providing end-to-end automation from source to production?",
                    "answer_1" => "Google Cloud Build",
                    "answer_2" => "Google Cloud Storage",
                    "answer_3" => "Google Cloud Functions",
                    "correct_answer" => 1,
                    "security_level" => "difficult"
                ],
                [
                    "question" => "How does encryption key management impact cloud security?",
                    "answer_1" => "Ensures secure storage and access to encryption keys",
                    "answer_2" => "Limits the types of encryption algorithms that can be used",
                    "answer_3" => "Reduces the cost of cloud storage solutions",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "What is the role of Identity and Access Management (IAM) in cloud security?",
                    "answer_1" => "Ensures only authorized users can access cloud resources",
                    "answer_2" => "Encrypts data during transmission",
                    "answer_3" => "Protect against SQL injection attacks",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "What is the primary security concern when using containers in a cloud environment?",
                    "answer_1" => "Ensuring the container image is free of vulnerabilities",
                    "answer_2" => "Deleting container logs regularly",
                    "answer_3" => "Managing the container's memory usage",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "How can vulnerabilities in a container image be detected?",
                    "answer_1" => "Regularly scan container images with security tools",
                    "answer_2" => "Use older versions of container images",
                    "answer_3" => "Make sure to store the container logs",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "How can network security be enhanced in a cloud-native environment?",
                    "answer_1" => "Use network segmentation and security groups",
                    "answer_2" => "Remove all firewall rules",
                    "answer_3" => "Enable network logging without alerts",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "How can cloud infrastructure be protected from insider threats?",
                    "answer_1" => "Implement least privilege access controls and monitoring",
                    "answer_2" => "Allow unrestricted access to all cloud services",
                    "answer_3" => "Use shared accounts for convenience",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "What is the main security challenge when using multi-cloud environments?",
                    "answer_1" => "Ensuring consistent security policies across different cloud providers",
                    "answer_2" => "Optimizing network latency between clouds",
                    "answer_3" => "Reducing the cost of cloud services",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "What is the purpose of encryption in securing cloud-native applications?",
                    "answer_1" => "To protect data both at rest and in transit",
                    "answer_2" => "To increase application performance",
                    "answer_3" => "To reduce the size of the data being processed",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "Which component connects front-end and back-end services in cloud architecture?",
                    "answer_1" => "API",
                    "answer_2" => "Firewall",
                    "answer_3" => "Router",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "What is the purpose of regular backups in cloud computing?",
                    "answer_1" => "To recover lost or corrupted data",
                    "answer_2" => "To store data locally",
                    "answer_3" => "To increase internet speed",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "What does \"resource pooling \" mean in cloud environments?",
                    "answer_1" => "Sharing resource among multiple users based on demand",
                    "answer_2" => "Storing all data locally",
                    "answer_3" => "Limiting access to files",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "Before sharing data in the cloud, what should organizations ensure?",
                    "answer_1" => "Compliance with regulations",
                    "answer_2" => "Data is stored in users local machines",
                    "answer_3" => "Disable backup of data",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "What does the term \"lock - in\" refer to in cloud comupting ?",
                    "answer_1" => "Dependency on single provider",
                    "answer_2" => "Data is stored locally",
                    "answer_3" => "Dependency on multiple providers",
                    "correct_answer" => 1,
                    "security_level" => "difficult"
                ],
                [
                    "question" => "Which statement is true regarding cloud storage in Saudi Arabia ? ",
                    "answer_1" => "Data residency is crucial for maintaining privacy",
                    "answer_2" => "All data freely transferred to any country ",
                    "answer_3" => "No regulation s governing data storage",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "What does \"data at rest\" refer to ?",
                    "answer_1" => "Data stored on physical or virtual disks",
                    "answer_2" => "Data that publicly accessiable ",
                    "answer_3" => "Data transmitted over the network",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "What is the benefit of using cloud applications?",
                    "answer_1" => "Accessibility from anywhere",
                    "answer_2" => "locally accessible ",
                    "answer_3" => "none",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "Which method is commonly used to enhance security during cloud authentication?",
                    "answer_1" => "Enable multi-factor authentication",
                    "answer_2" => "Disable multi-factor authentication",
                    "answer_3" => "Regular software updates",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ],
                [
                    "question" => "Which of the following is an example of a cloud identity provider ?",
                    "answer_1" => "Google Cloud Identity",
                    "answer_2" => "Microsoft 365",
                    "answer_3" => "Dropbox",
                    "correct_answer" => 1,
                    "security_level" => "easy"
                ]
            ],
            "ai" => [
                [
                    "question" => "____ is the process of discovering patterns, trends, and useful information
from large datasets using various algorithms, statistical methods, and machine learning techniques.",
                    "answer_1" => "Data mining",
                    "answer_2" => "Data encryption",
                    "answer_3" => "Data storage",
                    "security_level" => "difficult",
                    "correct_answer" => 1
                ],
                [
                    "question" => "This defines the ability to interpret the meaning of a piece of text",
                    "answer_1" => "Language understanding",
                    "answer_2" => "Language processing",
                    "answer_3" => "Language generation",
                    "security_level" => "difficult",
                    "correct_answer" => 1
                ],
                [
                    "question" => "This is helpful in producing text that is grammatically correct and conveys the intended meaning",
                    "answer_1" => "Language generation",
                    "answer_2" => "Language understanding",
                    "answer_3" => "Language processing",
                    "security_level" => "difficult",
                    "correct_answer" => 1
                ],
                [
                    "question" => "This helps in performing operations on a piece of text, such as tokenization, lemmatization, and part-of-speech tagging.",
                    "answer_1" => "Language processing",
                    "answer_2" => "Language generation",
                    "answer_3" => "Language understanding",
                    "security_level" => "difficult",
                    "correct_answer" => 1
                ],
                [
                    "question" => "What is a primary cybersecurity concern when deploying AI/ML models in sensitive environments?",
                    "answer_1" => "Privacy and data leakage",
                    "answer_2" => "Performance optimization",
                    "answer_3" => "Model explainability",
                    "security_level" => "easy",
                    "correct_answer" => 1
                ],
                [
                    "question" => "What is an effective way to prevent model inversion attacks?",
                    "answer_1" => "Differential privacy",
                    "answer_2" => "Data deduplication",
                    "answer_3" => "Feature scaling",
                    "security_level" => "difficult",
                    "correct_answer" => 1
                ],
                [
                    "question" => "What can adversarial examples in AI/ML models lead to?",
                    "answer_1" => "Model misclassification",
                    "answer_2" => "Faster training times",
                    "answer_3" => "Increased accuracy",
                    "security_level" => "easy",
                    "correct_answer" => 1
                ],
                [
                    "question" => "Which technique can be used to secure AI models from adversarial attacks?",
                    "answer_1" => "Adversarial training",
                    "answer_2" => "Increased dataset size",
                    "answer_3" => "Data normalization",
                    "security_level" => "easy",
                    "correct_answer" => 1
                ],
                [
                    "question" => "What should be avoided when handling sensitive data in AI/ML models?",
                    "answer_1" => "Storing sensitive data in plaintext",
                    "answer_2" => "Encrypting data in storage",
                    "answer_3" => "Implementing secure access controls",
                    "security_level" => "easy",
                    "correct_answer" => 1
                ],
                [
                    "question" => "Which method helps protect AI models against model poisoning attacks?",
                    "answer_1" => "Secure data provenance and access controls",
                    "answer_2" => "Faster data augmentation",
                    "answer_3" => "Removing unused features",
                    "security_level" => "easy",
                    "correct_answer" => 1
                ],
                [
                    "question" => "What is a risk of not securing the AI training pipeline?",
                    "answer_1" => "The model can be poisoned or manipulated.",
                    "answer_2" => "The model will have a higher accuracy.",
                    "answer_3" => "The model will have less bias.",
                    "security_level" => "easy",
                    "correct_answer" => 1
                ],
                [
                    "question" => "What type of attack involves reverse-engineering a model to extract its training data?",
                    "answer_1" => "Model inversion attack",
                    "answer_2" => "Data obfuscation attack",
                    "answer_3" => "Feature extraction attack",
                    "security_level" => "difficult",
                    "correct_answer" => 1
                ],
                [
                    "question" => "Which strategy can help reduce the risk of AI model theft?",
                    "answer_1" => "Model watermarking",
                    "answer_2" => "Reducing the size of the model",
                    "answer_3" => "Shortening the training process",
                    "security_level" => "easy",
                    "correct_answer" => 1
                ],
                [
                    "question" => "Why should AI/ML models be regularly monitored in production?",
                    "answer_1" => "To detect drift, anomalies, and potential attacks",
                    "answer_2" => "To reduce computation costs",
                    "answer_3" => "To increase data usage",
                    "security_level" => "easy",
                    "correct_answer" => 1
                ],
                [
                    "question" => "What is a secure practice when sharing AI/ML models with third parties?",
                    "answer_1" => "Sharing only obfuscated or encrypted models",
                    "answer_2" => "Sharing models in plaintext format",
                    "answer_3" => "Disabling API authentication",
                    "security_level" => "easy",
                    "correct_answer" => 1
                ],
                [
                    "question" => "How can federated learning contribute to secure AI?",
                    "answer_1" => "It allows models to be trained without centralizing sensitive data.",
                    "answer_2" => "It improves model accuracy by reducing privacy.",
                    "answer_3" => "It reduces the complexity of model training.",
                    "security_level" => "easy",
                    "correct_answer" => 1
                ],
                [
                    "question" => "What is a possible outcome of adversarial training in AI models?",
                    "answer_1" => "Increased robustness against adversarial attacks",
                    "answer_2" => "Lower hardware requirements",
                    "answer_3" => "Improved speed of inference",
                    "security_level" => "easy",
                    "correct_answer" => 1
                ],
                [
                    "question" => "Why is model fairness important in secure AI?",
                    "answer_1" => "It helps prevent bias and ensures equitable decision-making.",
                    "answer_2" => "It reduces the number of features needed.",
                    "answer_3" => "Improved speed of inference",
                    "security_level" => "easy",
                    "correct_answer" => 1
                ],
                [
                    "question" => "What is a best practice for securing AI model APIs?",
                    "answer_1" => "Implementing strong authentication and authorization mechanisms",
                    "answer_2" => "Making the API publicly accessible",
                    "answer_3" => "Using a shared secret for all users",
                    "security_level" => "easy",
                    "correct_answer" => 1
                ],
                [
                    "question" => "What is the primary concern when using pre-trained AI/ML models from third-party sources?",
                    "answer_1" => "Bias and adversarial vulnerabilities",
                    "answer_2" => "Data integrity validation",
                    "answer_3" => "Dataset scaling issues",
                    "security_level" => "easy",
                    "correct_answer" => 1
                ],
                [
                    "question" => "How can AI/ML models be protected against data poisoning attacks during training?",
                    "answer_1" => "Regular data auditing and validation",
                    "answer_2" => "Model encryption during inference",
                    "answer_3" => "Using differential learning rates",
                    "security_level" => "easy",
                    "correct_answer" => 1
                ],
                [
                    "question" => "Which attack can cause an AI/ML model to make incorrect predictions by subtly altering the input data?",
                    "answer_1" => "Adversarial attack",
                    "answer_2" => "Cross-validation attack",
                    "answer_3" => "Feature extraction attack",
                    "security_level" => "difficult",
                    "correct_answer" => 1
                ],
                [
                    "question" => "What is the risk of overfitting in AI/ML models related to security?",
                    "answer_1" => "The model may memorize sensitive data.",
                    "answer_2" => "The model will fail to generalize new attacks.",
                    "answer_3" => "The model will require more memory.",
                    "security_level" => "difficult",
                    "correct_answer" => 1
                ],
                [
                    "question" => "How can federated learning contribute to data security in AI/ML?",
                    "answer_1" => "It keeps training data decentralized on individual devices.",
                    "answer_2" => "It reduces the need for model testing.",
                    "answer_3" => "It centralizes data for easier access.",
                    "security_level" => "difficult",
                    "correct_answer" => 1
                ],
                [
                    "question" => "Why is it important to secure AI systems?",
                    "answer_1" => "To prevent hackers from misusing the system",
                    "answer_2" => "To increase the system's size.",
                    "answer_3" => "To allow more people to use it.",
                    "security_level" => "easy",
                    "correct_answer" => 1
                ],
                [
                    "question" => "Why is it risky to use AI systems that haven’t been checked for security?",
                    "answer_1" => "They can be tricked into giving incorrect answers.",
                    "answer_2" => "They will stop working after a while.",
                    "answer_3" => "They will lose their memory.",
                    "security_level" => "easy",
                    "correct_answer" => 1
                ],
                [
                    "question" => "How can companies keep AI systems safe?",
                    "answer_1" => "By checking for any signs of unusual or suspicious behavior.",
                    "answer_2" => "By only letting certain employees use them. ",
                    "answer_3" => "By increasing the number of users allowed on the system.",
                    "security_level" => "easy",
                    "correct_answer" => 1
                ],
                [
                    "question" => "What is a common attack on AI systems?",
                    "answer_1" => "Trying to trick the AI into making mistakes.",
                    "answer_2" => "Disabling the AI when no one is using it.",
                    "answer_3" => "Making the AI learn more slowly.",
                    "security_level" => "easy",
                    "correct_answer" => 1
                ],
                [
                    "question" => "Why should companies be careful when using AI to make decisions?",
                    "answer_1" => "AI might be biased and make unfair decisions.",
                    "answer_2" => "It will cost the company money",
                    "answer_3" => "It will waste the employees time",
                    "security_level" => "easy",
                    "correct_answer" => 1
                ],
                [
                    "question" => "What is machine learning?",
                    "answer_1" => "A technique for teaching computers to learn from data",
                    "answer_2" => "A programming language",
                    "answer_3" => "A hardware device",
                    "security_level" => "easy",
                    "correct_answer" => 1
                ]
            ]
        ];

        $data= [];

        foreach ($jayParsedAry as $envKey => $envValue) {
            foreach ($envValue as $question) {

                $answersIDs = [1, 2, 3];
                shuffle($answersIDs);

               $newArr = [
                    'question' =>$question['question'],
                    'answer_' . $answersIDs[0] =>$question['answer_1'],
                    'answer_' . $answersIDs[1] =>$question['answer_2'],
                    'answer_' . $answersIDs[2] =>$question['answer_3'],
                    'answer_4' =>'',

                    'correct_answer' => $answersIDs[0],
                    'security_level' => $question['security_level'],
                    'environment' => $envKey,
                ];
                $data[] = $newArr;
            }

        }



        QuestionV2::truncate();
        foreach ($data as $row) {
            $t = new QuestionV2;

            $t->question = $row['question'];
            $t->answer_1 = $row['answer_1'];
            $t->answer_2 = $row['answer_2'];
            $t->answer_3 = $row['answer_3'];
            $t->correct_answer = $row['correct_answer'];
            $t->security_level = $row['security_level'];
            $t->environment = $row['environment'];

            $t->save();
        }
        dump('done');

    }
    //====================================================>


}
