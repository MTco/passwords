<?php
namespace OCA\Passwords\Controller;

use \OCP\IRequest;
use \OCP\AppFramework\Http\DataResponse;
use \OCP\AppFramework\Controller;

use OCA\Passwords\Service\CategoryService;

class CategoryController extends Controller {

	private $service;
	private $userId;

	use Errors;

	public function __construct($AppName, IRequest $request, CategoryService $service, $UserId) {
		// allow getting categories and editing/saving them
		parent::__construct(
			$AppName,
			$request,
			'GET, POST, DELETE, PUT, PATCH',
			'Authorization, Content-Type, Accept',
			86400);
		$this->service = $service;
		$this->userId = $UserId;
	}

	/**
	 * @NoAdminRequired
	 */
	public function index() {
		return new DataResponse($this->service->findAll($this->userId));
	}

	/**
	 * @NoAdminRequired
	 *
	 * @param int $id
	 */
	public function show($id) {
		return $this->handleNotFound(function () use ($id) {
			return $this->service->find($id, $this->userId);
		});
	}

	/**
	 * @NoAdminRequired
	 *
	 * @param string $category_name
	 * @param string $category_colour
	 */
	public function create($categoryName, $categoryColour) {
		return $this->service->create($categoryName, $categoryColour, $this->userId);
	}

	/**
	 * @NoAdminRequired
	 *
	 * @param int $id
	 */
	public function destroy($id) {
		return $this->handleNotFound(function () use ($id) {
			return $this->service->delete($id, $this->userId);
		});
	}

}
