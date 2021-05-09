<?php


use App\Department;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::insert([
            'department_name' => 'Medicine',
            'icon' => 'Medicine.png',
            'details' => 'Medicine is the science and practice of establishing the diagnosis, prognosis, treatment, and prevention of disease. Medicine encompasses a variety of health care practices evolved to maintain and restore health by the prevention and treatment of illness. Contemporary medicine applies biomedical sciences, biomedical research, genetics, and medical technology to diagnose, treat, and prevent injury and disease, typically through pharmaceuticals or surgery, but also through therapies as diverse as psychotherapy, external splints and traction, medical devices, biologics, and ionizing radiation, amongst others.',
            'created_at' => Carbon::now()
        ]);
        Department::insert([
            'department_name' => 'Dental',
            'icon' => 'Dental.png',
            'details' => 'Dentistry, also known as Dental and Oral Medicine, is a branch of medicine that consists of the study, diagnosis, prevention, and treatment of diseases, disorders, and conditions of the oral cavity, commonly in the dentition but also the oral mucosa, and of adjacent and related structures and tissues, particularly in the maxillofacial (jaw and facial) area.[1] Although primarily associated with teeth among the general public, the field of dentistry or dental medicine is not limited to teeth but includes other aspects of the craniofacial complex including the temporomandibular joint and other supporting, muscular, lymphatic, nervous, vascular, and anatomical structures.',
            'created_at' => Carbon::now()
        ]);
        Department::insert([
            'department_name' => 'Cardiology',
            'icon' => 'Cardiology.png',
            'details' => 'Cardiology is a branch of medicine that deals with the disorders of the heart as well as some parts of the circulatory system. The field includes medical diagnosis and treatment of congenital heart defects, coronary artery disease, heart failure, valvular heart disease and electrophysiology. Physicians who specialize in this field of medicine are called cardiologists, a specialty of internal medicine. Pediatric cardiologists are pediatricians who specialize in cardiology. Physicians who specialize in cardiac surgery are called cardiothoracic surgeons or cardiac surgeons, a specialty of general surgery.',
            'created_at' => Carbon::now()
        ]);
        Department::insert([
            'department_name' => 'Neurology',
            'icon' => 'Neurology.png',
            'details' => 'Neurology  is a branch of medicine dealing with disorders of the nervous system. Neurology deals with the diagnosis and treatment of all categories of conditions and disease involving the central and peripheral nervous systems (and their subdivisions, the autonomic and somatic nervous systems), including their coverings, blood vessels, and all effector tissue, such as muscle. Neurological practice relies heavily on the field of neuroscience, the scientific study of the nervous system.',
            'created_at' => Carbon::now()
        ]);
        Department::insert([
            'department_name' => 'Orthopedic',
            'icon' => 'Orthopedic.png',
            'details' => 'Orthopedics is a medical specialty that focuses on the diagnosis, correction, prevention, and treatment of patients with skeletal deformities - disorders of the bones, joints, muscles, ligaments, tendons, nerves and skin. These elements make up the musculoskeletal system.

Your body\'s musculoskeletal system is a complex system of bones, joints, ligaments, tendons, muscles and nerves and allows you to move, work and be active. Once devoted to the care of children with spine and limb deformities, orthopedics now cares for patients of all ages, from newborns with clubfeet, to young athletes requiring arthroscopic surgery, to older people with arthritis.

The physicians who specialize in this area are called orthopedic surgeons or orthopedists.',
            'created_at' => Carbon::now()
        ]);
        Department::insert([
            'department_name' => 'Gastroenterology',
            'icon' => 'Gastroenterology.png',
            'details' => 'Gastroenterology[1] is the branch of medicine focused on the digestive system and its disorders.

Diseases affecting the gastrointestinal tract, which include the organs from mouth into anus, along the alimentary canal, are the focus of this speciality. Physicians practicing in this field are called gastroenterologists. They have usually completed about eight years of pre-medical and medical education, a year-long internship (if this is not a part of the residency), three years of an internal medicine residency, and two to three years in the gastroenterology fellowship. Gastroenterologists perform a number of diagnostic and therapeutic procedures including colonoscopy, endoscopy, endoscopic retrograde cholangiopancreatography (ERCP), endoscopic ultrasound and liver biopsy. Some gastroenterology trainees will complete a "fourth-year" (although this is often their seventh year of graduate medical education) in transplant hepatology, advanced endoscopy, inflammatory bowel disease, motility or other topics.',
            'created_at' => Carbon::now()
        ]);
        Department::insert([
            'department_name' => 'Skin',
            'icon' => 'Skin.png',
            'details' => 'Dermatology is the branch of medicine dealing with the skin, nails, hair ( functions & structures ) and its diseases. It is a specialty with both medical and surgical aspects. A dermatologist is specialist doctor that manages diseases, in the widest sense, and some cosmetic problems of the skin, hair and nails.',
            'created_at' => Carbon::now()
        ]);
        Department::insert([
            'department_name' => 'Eye',
            'icon' => 'Eye.png',
            'details' => 'Ophthalmology is a branch of medicine and surgery which deals with the diagnosis and treatment of eye disorders. An ophthalmologist is a specialist in ophthalmology. The credentials include a degree in medicine, followed by additional four to five years of ophthalmology residency training. Ophthalmology residency training programs may require a one year pre-residency training in internal medicine, pediatrics, or general surgery. Additional specialty training (or fellowship) may be sought in a particular aspect of eye pathology. Ophthalmologists are allowed to use medications to treat eye diseases, implement laser therapy, and perform surgery when needed. Ophthalmologists may participate in academic research on the diagnosis and treatment for eye disorders.',
            'created_at' => Carbon::now()
        ]);


    }
}
