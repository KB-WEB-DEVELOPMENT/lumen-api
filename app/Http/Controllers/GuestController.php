<?php

namespace App\Http\Controllers;

use App\User;
use App\Instructor;
use App\Student;
use App\Course;
use App\CourseRating;

use Illuminate\Http\Request;

use App\Transformers\InstructorTransformer;
use App\Transformers\StudentTransformer;
use App\Transformers\CourseTransformer;
use App\Transformers\InstructorStatsTransformer;

use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class GuestController
 * @package App\Http\Controllers
 */
class GuestController extends Controller
{
    /**
     * GET /api/v1/instructors
     * @return array
     */
    public function indexInstructors(): array
    {
        return $this->collection(Instructor::all(), new InstructorTransformer());
    }

    /**
     * GET /api/v1/students
     * @return array
     */
    public function indexStudents(): array
    {
        return $this->collection(Student::all(), new StudentTransformer());
    }
	
	/**
     * GET /api/v1/courses
     * @return array
     */
    public function indexCourses(): array
    {
        return $this->collection(Course::all(), new CourseTransformer());
    }
	
	/**
     * GET api/v1/instructors/stats
     * @return array
     */
    public function indexInstructorsStats(): array
    {
        return $this->collection(Instructor::all(), new InstructorStatsTransformer());
    }

    /**
     * GET api/v1/instructors/{instructorId}
     * @param integer $instructorId
     * @return mixed
     */
    public function showInstructor(int $instructorId): array
    {
        return $this->item(Instructor::findOrFail($instructorId), new InstructorTransformer());
    }
	
    /**
     * GET api/v1/students/{studentId}
     * @param integer $studentId
     * @return mixed
     */
    public function showStudent(int $studentId): array
    {
        return $this->item(Student::findOrFail($studentId), new StudentTransformer());
    }

    /**
     * GET api/v1/courses/{courseId}
     * @param integer $courseId
     * @return mixed
     */
    public function showCourse(int $courseId): array
    {
        return $this->item(Course::findOrFail($courseId), new CourseTransformer());
    }

    /**
     * GET api/v1/instructors/{instructorId}/stats
     * @param integer $instructorId
     * @return mixed
     */
    public function showInstructorStats(int $instructorId): array
    {
        return $this->item(Instructor::findOrFail($instructorId), new InstructorStatsTransformer());
    }
}
